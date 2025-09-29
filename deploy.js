// Charger les variables d'environnement depuis .env
require('dotenv').config();

const ftp = require("basic-ftp");
const fs = require("fs");
const path = require("path");

async function deploy() {
    const client = new ftp.Client();
    client.ftp.verbose = false;
    
    try {
        console.log("🔌 Connexion au serveur FTP...");
        
        // Utilisation des variables d'environnement du fichier .env
        await client.access({
            host: process.env.FTP_HOST,
            user: process.env.FTP_USER,
            password: process.env.FTP_PASSWORD,
            secure: false
        });
        
        console.log("✅ Connecté !");
        console.log("📁 Navigation vers le dossier du thème...");
        
        // Utiliser la variable d'environnement pour le chemin
        await client.cd(process.env.FTP_REMOTE);
        
        // Fonction récursive pour parcourir les fichiers
        async function uploadDir(localDir, remoteDir = "") {
            const files = fs.readdirSync(localDir);
            
            for (const file of files) {
                const localPath = path.join(localDir, file);
                const remotePath = remoteDir ? `${remoteDir}/${file}` : file;
                const stat = fs.statSync(localPath);
                
                // Ignorer certains fichiers/dossiers
                if (shouldIgnore(file, localPath)) {
                    continue;
                }
                
                if (stat.isDirectory()) {
                    try {
                        console.log(`📁 Création/vérif dossier: ${remotePath}`);
                        await client.ensureDir(remotePath);
                        
                        // Se replacer dans le dossier du thème
                        await client.cd(process.env.FTP_REMOTE);
                        
                        // Upload récursif du contenu
                        await uploadDir(localPath, remotePath);
                        
                        // Revenir au dossier principal
                        await client.cd(process.env.FTP_REMOTE);
                    } catch (err) {
                        console.log(`⚠️ Dossier ${remotePath} existe déjà`);
                    }
                } else {
                    try {
                        console.log(`📤 ${remotePath}`);
                        await client.uploadFrom(localPath, remotePath);
                    } catch (err) {
                        console.log(`❌ Erreur upload ${remotePath}:`, err.message);
                    }
                }
            }
        }
        
        // Fonction pour déterminer si un fichier doit être ignoré
        function shouldIgnore(filename, filepath) {
            const ignorePaths = [
                'node_modules',      // ⚠️ TRÈS IMPORTANT - jamais uploader !
                '.git',
                '.vscode',
                '.env',              // Ne jamais uploader le fichier .env !
                '.DS_Store',
                'deploy.js',         // Le script lui-même
                'package.json',
                'package-lock.json',
                '.gitignore',
                'README.md'
            ];
            
            const ignoreExtensions = [
                '.log',
                '.sql',
                '.zip',
                '.bak'
            ];
            
            if (ignorePaths.includes(filename)) {
                return true;
            }
            
            const ext = path.extname(filename);
            if (ignoreExtensions.includes(ext)) {
                return true;
            }
            
            if (filepath.includes('node_modules')) {
                return true;
            }
            
            return false;
        }
        
        console.log("🚀 Début du déploiement...\n");
        
        // Vérifier/créer les dossiers principaux
        const mainDirs = ['css', 'js', 'images', 'assets', 'inc', 'template-parts'];
        for (const dir of mainDirs) {
            if (fs.existsSync(path.join(__dirname, dir))) {
                try {
                    await client.ensureDir(dir);
                    console.log(`✅ Dossier ${dir} prêt`);
                } catch (err) {
                    // Le dossier existe déjà
                }
            }
        }
        
        // Revenir au dossier principal du thème
        await client.cd(process.env.FTP_REMOTE);
        
        // Uploader tous les fichiers
        await uploadDir(__dirname);
        
        console.log("\n✅ Déploiement terminé avec succès !");
        console.log("🌐 Site accessible sur : https://dev.cea.techniques-graphiques.be");
    }
    catch(err) {
        console.log("❌ Erreur:", err);
    }
    
    client.close();
}

deploy();
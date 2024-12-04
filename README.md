
# PEC-S1

Le projet demande que tous les commits soient signés. Vous pouvez passer par une signature avec une **clé SSH** si vous avez déjà fait une configuration auparavant. Cependant, si vous n'avez jamais configuré votre signature de commit,vous pouvez suivre cette méthode plutot simple avec **GPG**.

---

## Commits Autosignés avec GPG

### 1. **Installer GPG**
Assurez-vous que GPG est installé sur votre machine. Sous Linux, vous pouvez l'installer avec :
```bash
sudo apt install gnupg
```
Sur Windows, vous pouvez trouver l'installer GPG ici : https://gpg4win.org/

### 2. **Générer une clé GPG**
Pour générer une nouvelle clé GPG :
```bash
gpg --full-generate-key
```

### 3. **Lister vos clés GPG**
Une fois votre clé générée, listez-la pour obtenir son identifiant :
```bash
gpg --list-secret-keys --keyid-format=long
```

Exemple de sortie :
```
sec   rsa4096/ABCDEF1234567890 2024-12-03 [SC]
```
Notez l’identifiant de la clé (`ABCDEF1234567890` dans cet exemple).

### 4. **Configurer votre clé dans Git**
Ajoutez cette clé à votre configuration Git pour qu’elle soit utilisée pour signer vos commits :
```bash
git config --global user.signingkey ABCDEF1234567890
```

### 5. **Exporter votre clé publique pour GitHub**
Exportez votre clé publique pour l’ajouter à votre compte GitHub :
```bash
gpg --armor --export yoann.mallet@eemi.com
```

### 6. **Configurer Git pour utiliser GPG**
Assurez-vous que Git utilise GPG et non SSH pour les signatures :
```bash
git config --global gpg.format openpgp
```

### 7. **Ajouter votre clé publique à GitHub**
Ajoutez votre clé publique exportée à votre compte GitHub en suivant ce lien :  
[Github: ajouter la clé GPG dans les settings](https://github.com/settings/keys)

### 8. **Activer les commits signés automatiquement**
Pour que tous vos commits soient signés automatiquement, configurez Git ainsi :
```bash
git config --global commit.gpgsign true
```

### 9. **Vérifier vos commits signés**
Après avoir effectué un commit, vous pouvez vérifier que la signature est valide avec :
```bash
git log --show-signature
```

Si tout est correctement configuré, vous verrez un message comme celui là :
```
Good "gpg" signature for {username}
```

---



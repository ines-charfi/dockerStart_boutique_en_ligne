# Utilise l’image officielle PHP avec Apache (basée sur Debian)
FROM php:8.3-apache

# Update les packages pour être sure d'avoir les dernière mise à jour
RUN apt-get update && apt-get upgrade -y

# Installe les dépendances utiles et extensions PHP
# Met à jour la liste des paquets disponibles dans les dépôts Debian (nécessaire avant toute installation).
RUN apt-get update && apt-get install -y \
        # Permet de te connecter à une base MySQL ou MariaDB depuis le terminal.
        default-mysql-client \
        # Installe l’extension PHP pdo_mysql qui permet : D’utiliser PDO avec une base de données MySQL.
    && docker-php-ext-install pdo_mysql


# Copie les fichiers de ton site dans le dossier attendu par Apache
COPY . /var/www/html/


# Optionnel : Donne les bons droits (si tu modifies des fichiers dans le conteneur)
# www-data : C’est l’utilisateur par défaut utilisé par Apache dans la plupart des distributions Linux.
RUN chown -R www-data:www-data /var/www/html

# Port exposé par Apache
EXPOSE 80
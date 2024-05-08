import os
import sqlite3

# Nom du fichier de la base de données
nom_fichier_db = 'TRACK_EYE.db'

# Vérifier si la base de données existe déjà
if not os.path.exists(nom_fichier_db):
    # Si la base de données n'existe pas, la créer
    conn = sqlite3.connect(nom_fichier_db)
    conn.close()
    print("Base de données créée avec succès.")

# Exécuter le fichier SQL pour créer les tables
try:
    with sqlite3.connect(nom_fichier_db) as conn:
        cursor = conn.cursor()
        with open('creation_tables.sql', 'r') as sql_file:
            sql_script = sql_file.read()
            cursor.executescript(sql_script)
    print("Tables créées avec succès.")
except Exception as e:
    print(f"Une erreur s'est produite lors de la création des tables : {e}")

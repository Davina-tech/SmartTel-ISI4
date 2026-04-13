# SmartTel-ISI4

## Description du Projet
Projet d'analyse des données de churn des clients télécom. Ce projet inclut le nettoyage, la normalisation et la préparation des données pour l'analyse ou la modélisation prédictive.

## Dataset
Le dataset utilisé est `TelecomCustomersChurn.csv`, contenant des informations sur les clients d'une entreprise de télécommunications. Il comprend 7 043 lignes et plusieurs colonnes décrivant les caractéristiques des clients et leur statut de churn.

### Colonnes du Dataset
- **customerID** : Identifiant unique du client (string).
- **gender** : Genre du client (Male/Female).
- **SeniorCitizen** : Indique si le client est senior (0 = Non, 1 = Oui).
- **Partner** : Indique si le client a un partenaire (0 = Non, 1 = Oui).
- **Dependents** : Indique si le client a des dépendants (0 = Non, 1 = Oui).
- **tenure** : Nombre de mois que le client est avec l'entreprise (numérique, normalisé).
- **PhoneService** : Indique si le client a un service téléphonique (0 = Non, 1 = Oui).
- **MultipleLines** : Indique si le client a plusieurs lignes (Yes/No/No phone service).
- **InternetService** : Type de service internet (DSL/Fiber optic/No).
- **OnlineSecurity** : Indique si le client a une sécurité en ligne (Yes/No/No internet service).
- **OnlineBackup** : Indique si le client a une sauvegarde en ligne (Yes/No/No internet service).
- **DeviceProtection** : Indique si le client a une protection d'appareil (Yes/No/No internet service).
- **TechSupport** : Indique si le client a un support technique (Yes/No/No internet service).
- **StreamingTV** : Indique si le client a un streaming TV (Yes/No/No internet service).
- **StreamingMovies** : Indique si le client a un streaming de films (Yes/No/No internet service).
- **Contract** : Type de contrat (Month-to-month/One year/Two year).
- **PaperlessBilling** : Indique si la facturation est sans papier (0 = Non, 1 = Oui).
- **PaymentMethod** : Méthode de paiement (Electronic check/Mailed check/Bank transfer (automatic)/Credit card (automatic)).
- **MonthlyCharges** : Charges mensuelles (numérique, normalisé).
- **TotalCharges** : Charges totales (numérique, normalisé).
- **Churn** : Indique si le client a quitté (0 = Non, 1 = Oui).

### Prétraitement Effectué
1. **Chargement des données** : Importation depuis `test/TelecomCustomersChurn.csv`.
2. **Nettoyage** :
   - Suppression des espaces dans `TotalCharges`.
   - Conversion de `TotalCharges` en type numérique (erreurs forcées à NaN).
   - Imputation des valeurs manquantes dans `TotalCharges` par la médiane.
3. **Encodage** : Conversion des variables binaires (Churn, Partner, Dependents, PhoneService, PaperlessBilling) en 0/1.
4. **Normalisation** : Standardisation des colonnes numériques (`tenure`, `MonthlyCharges`, `TotalCharges`) à l'aide de `StandardScaler` pour une moyenne de 0 et un écart-type de 1.

### Fichiers
- `Telecom_clean.ipynb` : Notebook Jupyter pour le nettoyage et la normalisation des données.
- `Telecom_cleaned_normalized.csv` : Dataset nettoyé et normalisé, prêt pour l'utilisation (téléchargeable via le notebook).
- `test/TelecomCustomersChurn.csv` : Dataset original.

## Utilisation
1. Ouvrez `Telecom_clean.ipynb` dans Jupyter.
2. Exécutez les cellules pour reproduire le nettoyage.
3. Téléchargez `Telecom_cleaned_normalized.csv` pour l'analyse ou l'intégration web.

## Dépendances
- pandas
- scikit-learn
- matplotlib
- seaborn
- numpy

Installez avec : `pip install pandas scikit-learn matplotlib seaborn numpy`

## Auteur
[Votre Nom] - Projet ISI4
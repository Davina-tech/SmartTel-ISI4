import pandas as pd
import joblib

from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from sklearn.ensemble import RandomForestClassifier

# Charger les données
df = pd.read_csv("Telecom_cleaned.csv")

# Supprimer customerID
df.drop("customerID", axis=1, inplace=True)

# Conversion TotalCharges
df["TotalCharges"] = pd.to_numeric(
    df["TotalCharges"],
    errors="coerce"
)

df.fillna(0, inplace=True)

# Encodage
le = LabelEncoder()

for col in df.columns:
    if df[col].dtype == "object":
        df[col] = le.fit_transform(df[col])

# Séparation X et y
X = df.drop("Churn", axis=1)
y = df["Churn"]

# Train/Test
X_train, X_test, y_train, y_test = train_test_split(
    X,
    y,
    test_size=0.2,
    random_state=42
)

# Modèle
model = RandomForestClassifier(
    n_estimators=100,
    random_state=42
)

model.fit(X_train, y_train)

# Sauvegarde
joblib.dump(model, "churn_model.pkl")
joblib.dump(X.columns.tolist(), "feature_columns.pkl")
joblib.dump(X_test, "X_test.pkl")
joblib.dump(y_test, "y_test.pkl")

print("Fichiers créés avec succès")

# Afficher les colonnes utilisées
print(X.columns.tolist())

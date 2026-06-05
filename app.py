import streamlit as st
import pandas as pd
import joblib
import plotly.express as px
from sklearn.metrics import confusion_matrix, accuracy_score
import matplotlib.pyplot as plt

# Titre
st.title("📊 Dashboard Churn Client")

# Charger les données et le modèle
df = pd.read_csv("Telecom_cleaned.csv")
model = joblib.load("churn_model.pkl")

# ======================
# 📈 Indicateurs Clés
# ======================
st.subheader("📈 Indicateurs Clés")

col1, col2, col3 = st.columns(3)

nombre_clients = len(df)
taux_churn = (df["Churn"] == "Yes").mean() * 100
revenu_moyen = df["MonthlyCharges"].mean()

col1.metric("Nombre de clients", f"{nombre_clients:,}")
col2.metric("Taux de churn", f"{taux_churn:.2f}%")
col3.metric("Revenu moyen", f"{revenu_moyen:.2f}$")

# ======================
# 📊 Analyse des données
# ======================
st.subheader("📊 Analyse des données")

# Répartition du churn
churn_count = df["Churn"].value_counts()
fig = px.pie(values=churn_count.values, names=churn_count.index, title="Répartition du Churn")
st.plotly_chart(fig)

# Distribution de l'ancienneté
fig = px.histogram(df, x="tenure", nbins=30, title="Distribution de l'ancienneté")
st.plotly_chart(fig)

# Distribution des charges mensuelles
fig = px.histogram(df, x="MonthlyCharges", nbins=30, title="Distribution des charges mensuelles")
st.plotly_chart(fig)

# ======================
# 🔥 Importance des variables
# ======================
st.subheader("🔥 Importance des variables")

feature_names = joblib.load("feature_columns.pkl")
importance_df = pd.DataFrame({
    "Variable": feature_names,
    "Importance": model.feature_importances_
}).sort_values(by="Importance", ascending=False)

fig = px.bar(
    importance_df.head(10),
    x="Importance",
    y="Variable",
    orientation="h",
    title="Top 10 variables"
)
st.plotly_chart(fig)

# ======================
# 🎯 Matrice de confusion + Accuracy
# ======================
st.subheader("🎯 Matrice de confusion")

X_test = joblib.load("X_test.pkl")
y_test = joblib.load("y_test.pkl")
y_pred = model.predict(X_test)

cm = confusion_matrix(y_test, y_pred)

fig, ax = plt.subplots()
ax.imshow(cm)

for i in range(cm.shape[0]):
    for j in range(cm.shape[1]):
        ax.text(j, i, str(cm[i, j]), ha="center")

st.pyplot(fig)

# Accuracy
accuracy = accuracy_score(y_test, y_pred)
st.metric("Accuracy", f"{accuracy:.2%}")

# ======================
# 🤖 Prédiction interactive
# ======================
st.subheader("🤖 Prédiction interactive")

tenure = st.slider("Ancienneté (mois)", 0, 72, 12)
monthly = st.number_input("Charges mensuelles", 0.0, 200.0, 70.0)
total = st.number_input("Charges totales", 0.0, 10000.0, 1000.0)

if st.button("Prédire"):
    # Construire un DataFrame avec les mêmes colonnes
    input_data = pd.DataFrame([[tenure, monthly, total]], columns=["tenure", "MonthlyCharges", "TotalCharges"])
    
    # Compléter avec les colonnes manquantes
    for col in feature_names:
        if col not in input_data.columns:
            input_data[col] = 0

    # Réordonner les colonnes
    input_data = input_data[feature_names]

    prediction = model.predict(input_data)[0]
    if prediction == 1:
        st.error("⚠️ Le client risque de churner")
    else:
        st.success("✅ Le client est fidèle")

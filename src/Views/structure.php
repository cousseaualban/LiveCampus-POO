<form method="POST">
    <label for="header">En-tête :</label>
    <textarea name="header" id="header" rows="8"><?= htmlspecialchars($headerContent) ?></textarea>

    <label for="footer">Pied de page :</label>
    <textarea name="footer" id="footer" rows="5"><?= htmlspecialchars($footerContent) ?></textarea>

    <button type="submit">Enregistrer</button>
</form>
document.getElementById('inscription-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const pseudo = this.pseudo.value;
    const email = this.email.value;
    const password = this.password.value;

    fetch('includes/init.api.php?action=register', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ pseudo, email, password })
    })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) {
                window.location.href = '?page=home';
            }
        })
        .catch(err => {
            console.error('Erreur fetch:', err);
            alert('Erreur serveur: ' + err.message);
        });

});

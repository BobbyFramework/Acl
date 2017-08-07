Pour contribuer a ce projet : <br/>
1. Créer un fork du projet, et attachez le a votre namespace personnel
2. apporter vos modifications en pensant a la rétrocompatibilité
3. Testez vos modifications:
    - corrigez les problèmes remontés éventuels
4. commiter vos changements<br/>
    `$ git add`<br/>
    `$ git commit –m "changelog de ce que vous avez apporté"`
5. pusher votre branche<br/>
    `$ git push origin VotreNomUtilisateurBranch`
6. Si les comportements changent modifier les tests unitaires,
7. Documenter vos changements, envoyez un mail a l'équipe (ou dans la description du merge request) explicitant le contenu et le pourquoi (besoins) de vos modifications
8. Pensez a ajouter/mettre à jour votre projet dans le fichier README.MD a la section Which Team Using it
9. Créer une merge request entre votre branche et la branche principale sur laquelle votre code s'appuie (par ex 1.0.0).
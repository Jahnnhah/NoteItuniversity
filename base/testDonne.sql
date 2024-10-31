INSERT INTO etudiant (num_etu, nom, prenom, date_naissance, id_promotiom) VALUES
(1788, 'Iony', 'soa', '2000-01-15', 1),
(1785, 'Malala', 'soa', '2000-02-20', 15),
(1876, 'Rinah', 'valerie', '2000-03-25', 15),
(1787, 'Santatra', 'niaina', '2000-04-30', 15),
(0012, 'Soa', 'Soa', '2000-04-30', 1);


INSERT INTO config (id, code, config, valeur)
VALUES (3,'CONF3', 'type de calcul note matiere(1=Max,2=Moyenne)', 1);

INSERT INTO config (id, code, config, valeur)
VALUES (4,'CONF4', 'Montant rattrapage par matiere',25000);

INSERT INTO parametre (id, borneinf, bornesup, couleur)
VALUES (1,0,5,'red');

INSERT INTO parametre (id, borneinf, bornesup, couleur)
VALUES (2,6,10,'#b8860b'); --darkyellow

INSERT INTO parametre (id, borneinf, bornesup, couleur)
VALUES (3,11,20,'green');


delete from parametre;

delete from parametre where borneinf = 0;

select * from parametre;

INSERT INTO note (id, note, id_etudiant, id_matiere)
VALUES (2000, 8.00, 1, 1);

INSERT INTO note (id, note, id_etudiant, id_matiere)
VALUES (2001, 9.00, 1, 1);

INSERT INTO note (id, note, id_etudiant, id_matiere)
VALUES (2002, 10.00, 1, 1);

INSERT INTO matiereOption (id, groupe, id_semestre, id_matiere)
VALUES (50, -1, 1, 1);

select * from matiereOption where id = '50';
select * from note where id_etudiant = '2' and id_matiere = '22';
select * from config;
select * from semestre;

-- table temporaire

-- // $semestres[$i]['somme_credit']  = Note::getReleveDeNotes($id, $semestres[$i]->id)[0]->somme_credit;
-- <td><a href="{{ route('listeanne',['id'=>$etudiant->id]) }}" class="btn btn-info btn-md btn-blockr">Voir anne</a></td> --}}

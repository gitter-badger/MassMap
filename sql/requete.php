<?php

/*requ�te sur le serveur pour cr�er les tables*/
$query = "
DROP TABLE IF EXISTS public.test_indigenat;
CREATE TABLE public.test_indigenat AS
SELECT 
three.cd_ref_referentiel, 
three.nom_complet_taxon_referentiel, 
three.code_territoire,  
three.code_type_territoire, 
CASE 	WHEN four.\"indigenat\" IS NULL THEN 'taxon absent du territoire'
	ELSE four.\"indigenat\" END as \"indigenat\"
FROM
(SELECT cd_ref_referentiel, nom_complet_taxon_referentiel, code_territoire, code_type_territoire
FROM (
SELECT DISTINCT 
	rt.cd_ref_referentiel, rt.nom_complet_taxon_referentiel
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
ORDER BY rt.cd_ref_referentiel
) as one,
(
SELECT DISTINCT 
	code_territoire, code_type_territoire
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE code_type_territoire = 'REG'
ORDER BY code_territoire
) as two) as three
LEFT OUTER JOIN
(
SELECT DISTINCT 
	rt.cd_ref_referentiel, code_territoire, libelle_statut as \"indigenat\"
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE type_statut = 'INDI' AND code_type_territoire = 'REG'
ORDER BY rt.cd_ref_referentiel
) as four
ON three.cd_ref_referentiel = four.cd_ref_referentiel AND three.code_territoire = four.code_territoire
WHERE three.cd_ref_referentiel IS NOT NULL
ORDER BY three.cd_ref_referentiel;






DROP TABLE IF EXISTS public.test_lr;
CREATE TABLE public.test_lr AS
SELECT 
three.cd_ref_referentiel, 
three.nom_complet_taxon_referentiel, 
three.code_territoire,  
three.code_type_territoire, 
CASE 	WHEN four.\"liste_rouge\" IS NULL THEN 'ABSENT'
	ELSE four.\"liste_rouge\" END as \"liste_rouge\"
FROM
(SELECT cd_ref_referentiel, nom_complet_taxon_referentiel, code_territoire, code_type_territoire
FROM (
SELECT DISTINCT 
	rt.cd_ref_referentiel, rt.nom_complet_taxon_referentiel
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
ORDER BY rt.cd_ref_referentiel
) as one,
(
SELECT DISTINCT 
	code_territoire, code_type_territoire
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE code_type_territoire = 'REG'
ORDER BY code_territoire
) as two) as three
LEFT OUTER JOIN
(
SELECT DISTINCT 
	rt.cd_ref_referentiel, code_territoire, code_statut as \"liste_rouge\"
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE type_statut = 'LR' AND code_type_territoire = 'REG'
ORDER BY rt.cd_ref_referentiel
) as four
ON three.cd_ref_referentiel = four.cd_ref_referentiel AND three.code_territoire = four.code_territoire
WHERE three.cd_ref_referentiel IS NOT NULL
ORDER BY three.cd_ref_referentiel;







DROP TABLE IF EXISTS public.test_degnat;
CREATE TABLE public.test_degnat AS
SELECT 
three.cd_ref_referentiel, 
three.nom_complet_taxon_referentiel, 
three.code_territoire,  
three.code_type_territoire, 
CASE 	WHEN four.\"degnat\" IS NULL THEN 'ABSENT'
	ELSE four.\"degnat\" END as \"degnat\"
FROM
(SELECT cd_ref_referentiel, nom_complet_taxon_referentiel, code_territoire, code_type_territoire
FROM (
SELECT DISTINCT 
	rt.cd_ref_referentiel, rt.nom_complet_taxon_referentiel
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
ORDER BY rt.cd_ref_referentiel
) as one,
(
SELECT DISTINCT 
	code_territoire, code_type_territoire
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE code_type_territoire = 'REG'
ORDER BY code_territoire
) as two) as three
LEFT OUTER JOIN
(
SELECT DISTINCT 
	rt.cd_ref_referentiel, code_territoire, code_statut as \"degnat\"
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE type_statut = 'degnat' AND code_type_territoire = 'REG'
ORDER BY rt.cd_ref_referentiel
) as four
ON three.cd_ref_referentiel = four.cd_ref_referentiel AND three.code_territoire = four.code_territoire
WHERE three.cd_ref_referentiel IS NOT NULL
ORDER BY three.cd_ref_referentiel;







DROP TABLE IF EXISTS public.test_eee;
CREATE TABLE public.test_eee AS
SELECT 
three.cd_ref_referentiel, 
three.nom_complet_taxon_referentiel, 
three.code_territoire,  
three.code_type_territoire, 
CASE 	WHEN four.\"eee\" IS NULL THEN 'ABSENT'
	ELSE four.\"eee\" END as \"eee\"
FROM
(SELECT cd_ref_referentiel, nom_complet_taxon_referentiel, code_territoire, code_type_territoire
FROM (
SELECT DISTINCT 
	rt.cd_ref_referentiel, rt.nom_complet_taxon_referentiel
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
ORDER BY rt.cd_ref_referentiel
) as one,
(
SELECT DISTINCT 
	code_territoire, code_type_territoire
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE code_type_territoire = 'REG'
ORDER BY code_territoire
) as two) as three
LEFT OUTER JOIN
(
SELECT DISTINCT 
	rt.cd_ref_referentiel, code_territoire, code_statut as \"eee\"
	FROM taxa.referentiel_taxo rt 
	JOIN taxa.coor_taxon_reftaxo ctr ON rt.id_rattachement_referentiel = ctr.id_rattachement_referentiel 
	JOIN taxa.taxon_taxa tt ON tt.id_taxa_fcbn = ctr.id_taxa_fcbn 
	JOIN taxa.statuts s ON tt.id_taxa_fcbn = s.id_taxa_fcbn 
	JOIN taxa.liste_statuts ls ON ls.id_statut = s.id_statut
	JOIN taxa.liste_geo lg ON lg.id_territoire = s.id_territoire 
WHERE type_statut = 'LEEE' AND code_type_territoire = 'REG'
ORDER BY rt.cd_ref_referentiel
) as four
ON three.cd_ref_referentiel = four.cd_ref_referentiel AND three.code_territoire = four.code_territoire
WHERE three.cd_ref_referentiel IS NOT NULL
ORDER BY three.cd_ref_referentiel;
";

?>
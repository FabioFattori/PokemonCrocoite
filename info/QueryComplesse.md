# Query complesse Pokemon Crocoite

## Introduzione
Questo documento racchiude le idee per effettuare le query statistiche più complesse sui pokemon.

## Diagramma ER
Il diagramma ER è il seguente: \    
![ER](image.png)

## Classe A

### Utenti con le squadre più variegate
> Mostra i primi 10 utenti con con le squadre più variegate in termini di tipi di pokemon ed in secondo luogo di tipi di mosse conosciute dai pokemon.
```sql
SELECT  pokemon_types
       ,move_types
       ,users.email
FROM users
INNER JOIN
(
	SELECT  t1.pokemon_types
	       ,t2.move_types
	       ,t1.user_id
	FROM
	(
		SELECT  COUNT(distinct name) AS pokemon_types
		       ,user_id
		FROM
		(
			SELECT  DISTINCT t.*
			       ,teams.user_id
			FROM teams
			INNER JOIN exemplaries e
			ON e.team_id = teams.id
			INNER JOIN pokemon p
			ON p.id = e.pokemon_id
			INNER JOIN pokemon_type pt
			ON pt.pokemon_id = p.id
			INNER JOIN types t
			ON t.id = pt.type_id
		) AS Salamalecum
		GROUP BY  user_id
	) AS t1
	INNER JOIN
	(
		SELECT  COUNT(distinct id) AS move_types
		       ,user_id
		FROM
		(
			SELECT  DISTINCT t.*
			       ,teams.user_id
			FROM teams
			INNER JOIN exemplaries e
			ON e.team_id = teams.id
			INNER JOIN exemplary_move em
			ON em.exemplary_id = e.id
			INNER JOIN moves m
			ON m.id = em.move_id
			INNER JOIN types t
			ON t.id = m.type_id
		)as vnjdvfnd
		GROUP BY  user_id
	) AS t2
	ON t1.user_id = t2.user_id
) AS t3
ON t3.user_id = users.id
ORDER BY pokemon_types DESC, move_types DESC
```

### Pokemon con miglior miglioramento medio
> Mostra i primi 10 pokemon con il miglior miglioramento medio in termini di statistiche base.

```sql
SELECT  values_avarage
       ,pokemon.name AS pokemon_name
FROM pokemon
INNER JOIN
(
	SELECT  avarage_final AS values_avarage
	       ,qf.id         AS pokemon_id
	FROM
	(
		SELECT  AVG(avarage_final) AS avarage_final
		       ,p.id
		FROM pokemon p
		INNER JOIN
		(
			SELECT  e.id
			       ,pokemon_id
			       ,pa.avarage - ( speed + specialDefense + specialAttack + attack + defense ) / 5 AS avarage_final
			FROM exemplaries e
			INNER JOIN
			(
				SELECT  id
				       ,( speed + specialDefense + specialAttack + attack + defense ) / 5 AS avarage
				FROM exemplaries
				WHERE exemplary_id is null 
			) pa
			ON pa.id = e.exemplary_id
			INNER JOIN captureds c
			ON c.exemplary_id = e.id
			WHERE e.exemplary_id is not null 
		) AS ex
		ON ex.pokemon_id = p.id
		GROUP BY  p.id
	) AS qf
) AS t1
ON t1.pokemon_id = pokemon.id
ORDER BY values_avarage desc
```

Extra:
> Una classifica delle zone con il miglior miglioramento medio in termini di statistiche base.

### Utenti con il maggior numero di pokemon di ogni rarità catturati
> Mostra i primi 10 utenti con il maggior numero di pokemon di ogni rarità catturati.

L'utente dovrà selezionare la rarità di cui vuole visualizzare i primi 10 utenti.

### Rarità più vincenti
> Mostra le  rarità con il maggior numero di vittorie.
```sql
SELECT  r.name                       AS rarity
       ,win_count / exemplary_number AS average_win
FROM
(
	SELECT  r.id     AS rarity_id
	       ,COUNT(*) AS win_count
	FROM
	(
		SELECT  CASE WHEN b.winner = 1 THEN e1.pokemon_id
		             WHEN b.winner = 2 THEN e2.pokemon_id END AS winning_pokemon_id
		FROM battle_registries b
		JOIN exemplaries e1
		ON b.exemplary1_id = e1.id
		JOIN exemplaries e2
		ON b.exemplary2_id = e2.id
	) AS winners
	JOIN pokemon p
	ON winners.winning_pokemon_id = p.id
	JOIN rarities r
	ON p.rarity_id = r.id
	GROUP BY  r.id
) AS t1
JOIN
(
	SELECT  COUNT(*) AS exemplary_number
	       ,r.id     AS rarity_id
	FROM battle_registries br
	JOIN exemplaries e
	ON ( e.id = br.exemplary1_id or e.id = br.exemplary2_id )
	JOIN pokemon p
	ON p.id = e.pokemon_id
	JOIN rarities r
	ON r.id = p.rarity_id
	GROUP BY  r.id
) AS t2
ON t1.rarity_id = t2.rarity_id
JOIN rarities r
ON t1.rarity_id = r.id
ORDER BY average_win DESC
```

### Migliori zone con i pokemon più forti
> Mostra le prime 10 zone con i pokemon più forti in termini di statistiche base (al momento della cattura).

```sql
SELECT  average_power
       ,z.name AS zone_name
FROM
(
	SELECT  AVG( speed + specialDefense + specialAttack + attack + defense ) AS average_power
	       ,c.zone_id
	FROM exemplaries e
	JOIN captureds c
	ON c.exemplary_id = e.id
	GROUP BY  c.zone_id
) AS t1
JOIN zones z
ON z.id = t1.zone_id
ORDER BY average_power desc
```

### Tipo di pokemon più efficace contro un allenatore
> Mostra il tipo di pokemon più efficace contro un allenatore.

```sql
with BattlesWinner as (
select 
    CASE
    	WHEN br.winner = 1 then br.exemplary1_id
    	WHEN br.winner = 2 then br.exemplary2_id
    END as winner,
    CASE
    	WHEN br.winner = 1 then br.exemplary2_id
    	WHEN br.winner = 2 then br.exemplary1_id
    END as loser,
    br.battle_id
    from battle_registries br
)

select count(distinct e.exemplary_id) as win_amount, e.exemplary_id from exemplaries e
join teams t on t.id = e.team_id
join BattlesWinner bw on bw.winner = e.id
join battles b on b.id = bw.battle_id
where (b.user_1 = 2 or b.user_2 = 2) and t.user_id <> 2
group by  e.exemplary_id
```

### Pokemon Più efficace in battaglia
> Mostra il pokemon più efficace in generale.

```sql
WITH BattlesWinner AS
(
	SELECT  CASE WHEN br.winner = 1 THEN br.exemplary1_id
	             WHEN br.winner = 2 THEN br.exemplary2_id END AS winner
	       ,CASE WHEN br.winner = 1 THEN br.exemplary2_id
	             WHEN br.winner = 2 THEN br.exemplary1_id END AS loser
	FROM battle_registries br
)
SELECT  amount
       ,e.name AS pokemon_name
       ,u.email
FROM exemplaries e
JOIN
(
	SELECT  COUNT(*) AS amount
	       ,exemplary_id
	FROM exemplaries e
	JOIN BattlesWinner bw
	ON bw.winner = e.id
	GROUP BY  exemplary_id
) AS t1
ON t1.exemplary_id = e.id
JOIN teams t
ON t.id = e.team_id
JOIN users u
ON u.id = t.user_id
ORDER BY amount desc
```

### Analisi mosse più efficaci
> Mostra le mosse più efficaci in termini di vittorie.

Questa query analizza le mosse più efficaci in base ai risultati delle battaglie. Deve calcolare il tasso di
successo di ogni mossa e classificare le mosse in base a questo tasso. Ovvero effettuare una classifica delle
mosse più comuni tra i pokemon che vincono più battaglie

```sql
WITH BattlesWinner AS
(
	SELECT  CASE WHEN br.winner = 1 THEN br.exemplary1_id
	             WHEN br.winner = 2 THEN br.exemplary2_id END AS winner
	       ,CASE WHEN br.winner = 1 THEN br.exemplary2_id
	             WHEN br.winner = 2 THEN br.exemplary1_id END AS loser
	FROM battle_registries br
)
SELECT  COUNT(m.id) AS amount
       ,m.name      AS move_name
FROM exemplaries e
JOIN BattlesWinner bw
ON bw.winner = e.id
JOIN exemplary_move em
ON em.exemplary_id = e.id
JOIN moves m
ON m.id = em.move_id
GROUP BY  m.id
ORDER BY  amount desc
```
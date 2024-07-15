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
SELECT DISTINCT t.*, teams.user_id from teams inner join exemplaries e on e.team_id = teams.id inner join pokemon p on p.id = e.pokemon_id inner join pokemon_type pt on pt.pokemon_id = p.id inner join types t on t.id = pt.type_id
```

### Pokemon con miglior miglioramento medio
> Mostra i primi 10 pokemon con il miglior miglioramento medio in termini di statistiche base.

Extra:
> Una classifica delle zone con il miglior miglioramento medio in termini di statistiche base.

### Utenti con il maggior numero di pokemon di ogni rarità catturati
> Mostra i primi 10 utenti con il maggior numero di pokemon di ogni rarità catturati.

L'utente dovrà selezionare la rarità di cui vuole visualizzare i primi 10 utenti.

### Rarità più vincenti
> Mostra le  rarità con il maggior numero di vittorie.

### Migliori zone con i pokemon più forti
> Mostra le prime 10 zone con i pokemon più forti in termini di statistiche base (al momento della cattura).

### Tipo di pokemon più efficace contro un allenatore
> Mostra il tipo di pokemon più efficace contro un allenatore.

Extra:
> Mostra il tipo di pokemon più efficace in generale.

### Analisi mosse più efficaci
> Mostra le mosse più efficaci in termini di vittorie.

Questa query analizza le mosse più efficaci in base ai risultati delle battaglie. Deve calcolare il tasso di
successo di ogni mossa e classificare le mosse in base a questo tasso. Ovvero effettuare una classifica delle
mosse più comuni tra i pokemon che vincono più battaglie

## Classe B

### Numero di battaglie vinte e perse per ogni allenatore
> Mostra il numero di battaglie vinte e perse per ogni allenatore.

### Esemplare più catturato
> Mostra il pokemon più catturato.

### Allenatori con i pokemon più forti
> Mostra i primi 10 allenatori con i pokemon più forti in termini di statistiche base.

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StatsController extends Controller
{
    public function index(){
        $params = [
            "mostVariegatedPlayerTeam" => $this->mostVariegatedPlayerTeams(),
            "bestPokemonForUpgradeAverage" => $this->bestPokemonForUpgradeAverage(),
            "mostWinningRarityAverage" => $this->mostWinningRarityAverage(),
            "zoneWithGreatestPokemon" => $this->zoneWithGreatestPokemon()
        ];

        return Inertia::render('Stats', $params);
    }

    private function mostVariegatedPlayerTeams(){
        return DB::select("select pokemon_types, move_types, users.email from users inner join (
select t1.pokemon_types, t2.move_types, t1.user_id from (
    select count(distinct name) as pokemon_types, user_id
        from(
        SELECT DISTINCT t.*, teams.user_id from teams inner join exemplaries e on e.team_id = teams.id inner join pokemon p on p.id = e.pokemon_id inner join pokemon_type pt on pt.pokemon_id = p.id inner join types t on t.id = pt.type_id) as Salamalecum GROUP By user_id
) as t1
	inner join (select count(distinct id) as move_types, user_id from (
SELECT DISTINCT t.*, teams.user_id from teams inner join exemplaries e on e.team_id = teams.id inner join exemplary_move em on em.exemplary_id = e.id inner join moves m on m.id = em.move_id inner join types t on t.id = m.type_id )as vnjdvfnd group by user_id) as t2 on t1.user_id = t2.user_id
    ) as t3 on t3.user_id = users.id
    order by pokemon_types DESC, move_types DESC");
    }

    private function bestPokemonForUpgradeAverage(){
        return DB::select("select values_avarage, pokemon.name as pokemon_name from pokemon inner join (
select avarage_final as values_avarage, qf.id as pokemon_id from (
select avg(avarage_final) as avarage_final, p.id from pokemon p inner join (
select e.id, pokemon_id, pa.avarage - (speed + specialDefense + specialAttack + attack + defense) / 5 as avarage_final from exemplaries e inner join (select id, (speed + specialDefense + specialAttack + attack + defense) / 5 as avarage from exemplaries 
     where exemplary_id is null) pa on pa.id = e.exemplary_id inner join captureds c on c.exemplary_id = e.id where e.exemplary_id is not null

    ) as ex on ex.pokemon_id = p.id
    GROUP by p.id
    ) as qf 
   ) as t1 on t1.pokemon_id = pokemon.id
   order by values_avarage desc
");
    }

    private function mostWinningRarityAverage(){
        return DB::select("select 
	r.name as rarity,
    win_count / exemplary_number as average_win
    from (

SELECT
    r.id AS rarity_id,
    COUNT(*) AS win_count
FROM
    (
        SELECT
            CASE
                WHEN b.winner = 1 THEN e1.pokemon_id
                WHEN b.winner = 2 THEN e2.pokemon_id
            END AS winning_pokemon_id
        FROM
            battle_registries b
        JOIN
            exemplaries e1 ON b.exemplary1_id = e1.id
        JOIN
            exemplaries e2 ON b.exemplary2_id = e2.id
    ) AS winners
JOIN
    pokemon p ON winners.winning_pokemon_id = p.id
JOIN
    rarities r ON p.rarity_id = r.id
GROUP BY
    r.id
) as t1 join (select count(*) as exemplary_number, r.id as rarity_id from battle_registries br join exemplaries e on (e.id = br.exemplary1_id or e.id = br.exemplary2_id) join pokemon p on p.id = e.pokemon_id join rarities r on r.id = p.rarity_id
group by r.id) as t2 on t1.rarity_id = t2.rarity_id
join rarities r on t1.rarity_id = r.id
ORDER BY
    average_win DESC");
    }

    private function zoneWithGreatestPokemon(){
        return DB::select("select average_power, z.name as zone_name from (
select avg(speed + specialDefense + specialAttack + attack + defense) as average_power, c.zone_id from exemplaries e
    join captureds c on c.exemplary_id = e.id
GROUP by c.zone_id 
    ) as t1 join zones z on z.id = t1.zone_id
    order by average_power desc");
    }
}

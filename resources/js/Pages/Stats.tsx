import {
    Stack,
    Typography,
    Container,
    Box,
    FormControl,
    InputLabel,
    MenuItem,
    Select,
} from "@mui/material";
import ChartManager from "../Components/ChartManager";
import { router } from "@inertiajs/react";
import SideBar from "../Components/SideBar";
import userMode from "../Components/userMode";

interface StatsProps {
    rarities: {
        id: number;
        name: string;
    }[];
    rarityId: number;
    mostVariegatedPlayerTeam: {
        pokemon_types: number;
        move_types: number;
        email: string;
    }[];
    bestPokemonForUpgradeAverage: {
        values_avarage: number;
        pokemon_name: string;
    }[];
    playerWithMoreRarities: {
        amount: number;
        email: string;
    }[];
    mostWinningRarityAverage: {
        average_win: number;
        rarity: string;
    }[];
    zoneWithGreatestPokemon: {
        zone_name: string;
        average_power: number;
    }[];
    greatestPokemon: {
        amount: number;
        pokemon_name: string;
        email: string;
    }[];
    greatestMoves: {
        amount: number;
        move_name: string;
    }[];
}

const Stats = (props: StatsProps) => {
    const {
        mostVariegatedPlayerTeam,
        bestPokemonForUpgradeAverage,
        mostWinningRarityAverage,
        zoneWithGreatestPokemon,
        greatestPokemon,
        greatestMoves,
        playerWithMoreRarities,
    } = props;
    return (
        <>
            <SideBar title={"Statistice"} mode={userMode.user} />
            <Container sx={{ mt: 10 }}>
                <Stack spacing={1}>
                    <Typography variant="h4">Statistiche generali</Typography>
                    <Box>
                        <ChartManager
                            label=""
                            title="visualizzare la classifica degli utenti con le squadre più variegate"
                            x={mostVariegatedPlayerTeam
                                .map((team) => team.email)
                                .concat([""])}
                            y={mostVariegatedPlayerTeam
                                .map((team) => team.pokemon_types)
                                .concat([0])}
                        />
                    </Box>
                    <Box>
                        <ChartManager
                            label=""
                            title="visualizzare i Pokémon con il miglioramento medio più alto"
                            x={bestPokemonForUpgradeAverage
                                .map((q) => q.pokemon_name)
                                .concat([""])}
                            y={bestPokemonForUpgradeAverage
                                .map((q) => Number(q.values_avarage))
                                .concat([0])}
                        />
                    </Box>
                    <Box>
                        <FormControl fullWidth>
                            <InputLabel id="demo-simple-select-label">
                                Rarità
                            </InputLabel>
                            <Select
                                labelId="demo-simple-select-label"
                                id="demo-simple-select"
                                value={props.rarityId}
                                label="Rarità"
                                onChange={(e) =>
                                    router.get(
                                        "/stats",
                                        {
                                            rarityId: e.target.value,
                                        },
                                        {
                                            preserveScroll: true,
                                        }
                                    )
                                }
                            >
                                {props.rarities.map((r) => (
                                    <MenuItem key={r.id} value={r.id}>
                                        {r.name}
                                    </MenuItem>
                                ))}
                            </Select>
                        </FormControl>
                        <ChartManager
                            label=""
                            title="visualizzare gli utenti con il maggior numero di esemplari catturati di una rarità selezionata"
                            x={playerWithMoreRarities
                                .map((q) => q.email)
                                .concat([""])}
                            y={playerWithMoreRarities
                                .map((q) => Number(q.amount))
                                .concat([0])}
                        />
                    </Box>
                    <Box>
                        <ChartManager
                            label=""
                            title="visualizzare le rarità più vincenti"
                            x={mostWinningRarityAverage
                                .map((q) => q.rarity)
                                .concat([""])}
                            y={mostWinningRarityAverage
                                .map((q) => Number(q.average_win))
                                .concat([0])}
                        />
                    </Box>
                    <Box>
                        <ChartManager
                            label=""
                            title="visualizzare le zone con i Pokémon più forti"
                            x={zoneWithGreatestPokemon
                                .map((q) => q.zone_name)
                                .concat([""])}
                            y={zoneWithGreatestPokemon
                                .map((q) => Number(q.average_power))
                                .concat([0])}
                        />
                    </Box>
                    <Box>
                        <ChartManager
                            label=""
                            title="visualizzare gli esemplari più efficaci in battaglia"
                            x={greatestPokemon
                                .map((q) => q.pokemon_name + " di " + q.email)
                                .concat([""])}
                            y={greatestPokemon
                                .map((q) => Number(q.amount))
                                .concat([0])}
                        />
                    </Box>
                    <Box>
                        <ChartManager
                            label=""
                            title="visualizzare le mosse più efficaci in battaglia"
                            x={greatestMoves
                                .map((q) => q.move_name)
                                .concat([""])}
                            y={greatestMoves
                                .map((q) => Number(q.amount))
                                .concat([0])}
                        />
                    </Box>
                </Stack>
            </Container>
        </>
    );
};

export default Stats;

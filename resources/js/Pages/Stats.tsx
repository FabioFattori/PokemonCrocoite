import {
    Stack,
    Typography,
    Container,
    Box,
    Tab,
    Tabs,
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
    mostVariegatedPlayerTeam: {
        pokemon_types: number;
        move_types: number;
        email: string;
    }[];
    bestPokemonForUpgradeAverage: {
        values_avarage: number;
        pokemon_name: string;
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
    } = props;
    return (
        <>
            <SideBar title={"Statistice"} mode={userMode.user} />
            <Container>
                <Stack spacing={1}>
                    <Typography variant="h4">Statistiche generali</Typography>
                    <Box>
                        <ChartManager
                            label=""
                            title="Allenatori con i pokemon più variegati (in casi di parità si considera il numero di tipi di mosse)"
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
                            title="Pokemon con il miglior miglioramento medio tra i loro esemplari"
                            x={bestPokemonForUpgradeAverage
                                .map((q) => q.pokemon_name)
                                .concat([""])}
                            y={bestPokemonForUpgradeAverage
                                .map((q) => Number(q.values_avarage))
                                .concat([0])}
                        />
                    </Box>
                    <Box>
                        <ChartManager
                            label=""
                            title="Rarirità dei pokemon con la media di vittorie più alta (la media è relativa al numero di esemplari presenti)"
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
                            title="Zone con i pokemon più potenti al momento della cattura"
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
                            title="Esemplari più forti per battaglie vinte"
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
                            title="Mosse più presenti negli esemplari che hanno vinto le battaglie"
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

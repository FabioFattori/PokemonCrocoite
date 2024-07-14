import HomeIcon from '@mui/icons-material/Home';
import PetsIcon from '@mui/icons-material/Pets';
import CatchingPokemonIcon from '@mui/icons-material/CatchingPokemon';
import LogoutIcon from '@mui/icons-material/Logout';

interface Route{
    Title: string;
    Path: string;
    Icon?: any | null;
}

export default [
    {
        Title: "Home",
        Path: "/",
        Icon: HomeIcon,
    },
    {
        Title: "Esemplari",
        Path: "/user/exemplaries",
        Icon: PetsIcon,
    },
    {
        Title: "Team",
        Path: "/user/userTeam",
        Icon: CatchingPokemonIcon,
    },
    {
        Title: "Logout",
        Path: "/logout",
        Icon: LogoutIcon,
    }

] as Route[];
import HomeIcon from '@mui/icons-material/Home';
import CatchingPokemonIcon from '@mui/icons-material/CatchingPokemon';
import LogoutIcon from '@mui/icons-material/Logout';
import ArchiveIcon from '@mui/icons-material/Archive';

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
        Title: "Team",
        Path: "/user/userTeam",
        Icon: CatchingPokemonIcon,
    },
    {
        Title: "Box",
        Path: "/user/boxes",
        Icon: ArchiveIcon,
    },
    {
        Title: "Logout",
        Path: "/logout",
        Icon: LogoutIcon,
    }

] as Route[];
import HomeIcon from '@mui/icons-material/Home';
import CatchingPokemonIcon from '@mui/icons-material/CatchingPokemon';
import LogoutIcon from '@mui/icons-material/Logout';
import ArchiveIcon from '@mui/icons-material/Archive';
import SportsKabaddiIcon from '@mui/icons-material/SportsKabaddi';
import HealthAndSafetyIcon from '@mui/icons-material/HealthAndSafety';
import BackpackIcon from '@mui/icons-material/Backpack';
import EqualizerIcon from '@mui/icons-material/Equalizer';
import MapIcon from '@mui/icons-material/Map';
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
        Icon: HealthAndSafetyIcon,
    },
    {
        Title: "Box",
        Path: "/user/boxes",
        Icon: ArchiveIcon,
    },
    {
        Title: "Catture",
        Path: "/user/captures",
        Icon: CatchingPokemonIcon,
    },
    {
        Title: "Battaglie Online",
        Path: "/user/battles",
        Icon: SportsKabaddiIcon,
    },
    {
        Title: "Zaino",
        Path: "/user/bag",
        Icon: BackpackIcon,
    },{
        Title: "Mappa di gioco",
        Path: "/user/map",
        Icon: MapIcon,
    },
    {
        Title: "Statistiche",
        Path: "/stats",
        Icon: EqualizerIcon,
    },
    {
        Title: "Logout",
        Path: "/logout",
        Icon: LogoutIcon,
    }

] as Route[];
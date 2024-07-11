import HomeIcon from '@mui/icons-material/Home';
import PetsIcon from '@mui/icons-material/Pets';
import PersonIcon from '@mui/icons-material/Person';
import LogoutIcon from '@mui/icons-material/Logout';
import SignLanguageIcon from '@mui/icons-material/SignLanguage';
import TransgenderIcon from '@mui/icons-material/Transgender';
import BiotechIcon from '@mui/icons-material/Biotech';
import ArchiveIcon from '@mui/icons-material/Archive';
import WifiProtectedSetupIcon from '@mui/icons-material/WifiProtectedSetup';
import LocationOnIcon from '@mui/icons-material/LocationOn';
import MapIcon from '@mui/icons-material/Map';
import FitnessCenterIcon from '@mui/icons-material/FitnessCenter';

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
        Path: "/admin/exemplaries",
        Icon: PetsIcon,
    },
    {
        Title: "Utenti",
        Path: "/admin/users",
        Icon: PersonIcon,
    },
    {
        Title: "Mosse",
        Path: "/admin/moves",
        Icon: SignLanguageIcon,
    },
    {
        Title: "Genere Pokemon",
        Path: "/admin/genders",
        Icon: TransgenderIcon,
    },
    {
        Title: "Razze Pokemon",
        Path: "/admin/pokemons",
        Icon: BiotechIcon,
    },
    {
        Title: "Box Pokemon",
        Path: "/admin/boxes",
        Icon: ArchiveIcon,
    },
    {
        Title: "Effeti Pokemon",
        Path: "/admin/effectivnesses",
        Icon: WifiProtectedSetupIcon,
    },
    {
        Title:"Zone",
        Path:"/admin/zones",
        Icon: MapIcon
    },{
        Title:"Palestre",
        Path:"/admin/gyms",
        Icon: FitnessCenterIcon
    },
    {
        Title:"Posizioni",
        Path:"/admin/positions",
        Icon: LocationOnIcon
    },
    {
        Title: "Logout",
        Path: "/logout",
        Icon: LogoutIcon,
    },

] as Route[];
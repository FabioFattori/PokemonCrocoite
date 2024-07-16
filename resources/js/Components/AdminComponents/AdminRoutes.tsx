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
import EmojiNatureIcon from '@mui/icons-material/EmojiNature';
import PlumbingIcon from '@mui/icons-material/Plumbing';
import SportsKabaddiIcon from '@mui/icons-material/SportsKabaddi';
import StarIcon from '@mui/icons-material/Star';
import SmartToyIcon from '@mui/icons-material/SmartToy';
import PrecisionManufacturingIcon from '@mui/icons-material/PrecisionManufacturing';
import HeartBrokenIcon from '@mui/icons-material/HeartBroken';
import HistoryEduIcon from '@mui/icons-material/HistoryEdu';

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
        Title: "Battaglie tra allenatori",
        Path: "/admin/battles",
        Icon: SportsKabaddiIcon,
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
        Title: "Nature Pokemon",
        Path: "/admin/natures",
        Icon: EmojiNatureIcon,
    },
    {
        Title: "Razze Pokemon",
        Path: "/admin/pokemons",
        Icon: BiotechIcon,
    },
    {
        Title: "Mn Mt",
        Path: "/admin/mnmts",
        Icon: PrecisionManufacturingIcon,
    },
    {
        Title: "Rarità Pokemon",
        Path: "/admin/rarities",
        Icon: StarIcon,
    },
    {
        Title: "Stati Pokemon",
        Path: "/admin/states",
        Icon: HeartBrokenIcon,
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
        Title: "Oggetti da Battaglia",
        Path:"/admin/tools",
        Icon: PlumbingIcon,
    },
    {
        Title: "Oggetti della storia",
        Path:"/admin/storyTools",
        Icon: HistoryEduIcon,
    },
    {
        Title:"Zone",
        Path:"/admin/zones",
        Icon: MapIcon
    },{
        Title:"Palestre",
        Path:"/admin/gyms",
        Icon: FitnessCenterIcon
    },{
        Title: "Npc",
        Path: "/admin/npcs",
        Icon: SmartToyIcon,
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
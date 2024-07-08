import HomeIcon from '@mui/icons-material/Home';
import PetsIcon from '@mui/icons-material/Pets';
import PersonIcon from '@mui/icons-material/Person';
import LogoutIcon from '@mui/icons-material/Logout';
import SignLanguageIcon from '@mui/icons-material/SignLanguage';
import TransgenderIcon from '@mui/icons-material/Transgender';
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
        Title: "Logout",
        Path: "/logout",
        Icon: LogoutIcon,
    },

] as Route[];
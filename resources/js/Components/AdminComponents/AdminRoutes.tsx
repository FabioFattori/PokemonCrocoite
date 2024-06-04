import HomeIcon from '@mui/icons-material/Home';
import PetsIcon from '@mui/icons-material/Pets';
import PersonIcon from '@mui/icons-material/Person';

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

] as Route[];

import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button} from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import HealthAndSafetyIcon from '@mui/icons-material/HealthAndSafety';
import { SignLanguage } from "@mui/icons-material";

function GenericExemplary() {
    var exemplaries = (usePage().props.EsemplariInBox as any[]) ?? null;
    var t1 = (usePage().props.t1 as string) ?? "";
    var t2 = (usePage().props.t2 as string) ?? "";
    let btn = [
        {
            label: "mostra Mosse",
            icon: SignLanguage,
            method: ({ props }: { props: any }) => {
                router.get("/user/moves",{id:props[0].id});
            },
        },
        {
            label: "Sposta nella Squadra",
            icon: HealthAndSafetyIcon,
            method: ({ props }: { props: any }) => {
                router.post("/user/exemplary/inTeam", { id: props[0].id });
            },
        },
    ] as unknown as Button[];
    return (
        <>
            <SideBar title={t1} mode={userMode.user} />
            <GeneralTable
                tableTitle={t2}
                dbObject={exemplaries}
                buttons={btn}
            />
        </>
    );
}

export default GenericExemplary;

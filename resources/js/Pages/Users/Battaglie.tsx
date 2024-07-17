import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import SportsMmaIcon from '@mui/icons-material/SportsMma';

function Battaglie() {
    var battles = (usePage().props.battles as any[]) ?? null;
    setTableToUse("battles");

    let btn = [
        
        {
            label: "Mostra Pokemon Coinvolti",
            icon: SportsMmaIcon,
            method: ({ props }: { props: any }) => {
                router.get("/user/singleBattle", { id: props[0].id });
            },
        },
    ] as unknown as Button[];
    return (
        <>
            <SideBar title={"Tutti i le battaglie online svolte"} mode={userMode.user} />
            <GeneralTable tableTitle="Battaglie" dbObject={battles} buttons={btn} />
        </>
    );
}

export default Battaglie;

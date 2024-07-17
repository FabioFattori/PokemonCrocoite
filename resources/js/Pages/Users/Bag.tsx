import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import OutboxIcon from '@mui/icons-material/Outbox';

function Bag() {
    var mnMT = (usePage().props.mnMT as any[]) ?? null;
    var story = (usePage().props.story as any[]) ?? null;
    var battleTool = (usePage().props.battleTool as any[]) ?? null;
    setTableToUse("mnMT");

    let btn = [] as unknown as Button[];
    return (
        <>
            <SideBar title={"Borsa"} mode={userMode.user}/>
            <GeneralTable
                tableTitle="Macchine Tecniche e Macchine Nascoste"
                dbObject={mnMT}
                buttons={btn}
            />
            <GeneralTable
                tableTitle="Oggetti della storia"
                dbObject={story}
                buttons={btn}
            />
            <GeneralTable
                tableTitle="Oggetti per le battaglie"
                dbObject={battleTool}
                buttons={btn}
            />
        </>
    );
  
}

export default Bag
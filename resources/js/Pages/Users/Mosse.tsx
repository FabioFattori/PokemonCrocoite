import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import OutboxIcon from '@mui/icons-material/Outbox';

function Mosse() {
    var moves = (usePage().props.moves as any[]) ?? null;
    setTableToUse("moves");

    let btn = [] as unknown as Button[];
    return (
        <>
            <SideBar title={"Mosse del pokemon selezionato"} mode={userMode.user}/>
            <GeneralTable
                tableTitle="Mosse"
                dbObject={moves}
                buttons={btn}
            />
        </>
    );
  
}

export default Mosse
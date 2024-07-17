import { router, usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { Button, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
import OutboxIcon from '@mui/icons-material/Outbox';

function Catture() {
    var captures = (usePage().props.captures as any[]) ?? null;
    setTableToUse("captures");

    
    return (
        <>
            <SideBar title={"Tutti le tue catture"} mode={userMode.user}/>
            <GeneralTable
                tableTitle="Catture"
                dbObject={captures}
                buttons={[]}
            />
        </>
    );
  
}

export default Catture
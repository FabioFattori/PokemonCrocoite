import { usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { buttons,setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";
function Esemplari() {
    
    var exemplaries = (usePage().props.exemplaries as any[]) ?? null;
    setTableToUse("exemplaries");
    return (
        <>
            <SideBar title={"Esemplari"} mode={userMode.user}/>
            <GeneralTable
                tableTitle="Esemplari"
                dbObject={exemplaries}
                buttons={buttons}
            />
        </>
    );
}

export default Esemplari;

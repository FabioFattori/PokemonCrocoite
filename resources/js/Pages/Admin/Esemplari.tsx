import { usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { buttons,setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";

function Esemplari() {
    
    var exemplaries = (usePage().props.exemplaries as any[]) ?? null;
    setTableToUse("exemplaries");
    return (
        <>
            <SideBar title={"Esemplari"} />
            <GeneralTable
                tableTitle="Esemplari"
                dbObject={exemplaries}
                buttons={buttons}
            />
        </>
    );
}

export default Esemplari;

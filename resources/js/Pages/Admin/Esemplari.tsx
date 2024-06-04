import { usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { buttons } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";

function Esemplari() {
    
    var exemplaries = (usePage().props.exemplaries as any[]) ?? null;
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

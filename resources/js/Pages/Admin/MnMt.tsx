import { usePage } from "@inertiajs/react";
import { buttons, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import GeneralTable from "../../Components/GeneralTable";
import userMode from "../../Components/userMode";
import React from "react";
function MnMt() {
    var mnmts = (usePage().props.mnmts as any[]) ?? null;
    setTableToUse("mnmts");

    React.useEffect(() => {
        console.log(mnmts);
    }, []);

    return (
        <>
            <SideBar title={"Macchine Nascoste e Macchine Tecniche"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Mn Mt"
                dbObject={mnmts}
                buttons={buttons}
            />
        </>
    );
}

export default MnMt;

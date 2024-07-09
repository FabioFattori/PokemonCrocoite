import { usePage } from "@inertiajs/react";
import { buttons, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import GeneralTable from "../../Components/GeneralTable";
import userMode from "../../Components/userMode";
import React from "react";

function Mosse() {
    var moves = (usePage().props.moves as any[]) ?? null;
    setTableToUse("moves");

    React.useEffect(() => {
        console.log(moves);
    }, []);

    return (
        <>
            <SideBar title={"Mosse"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Tutte le mosse presenti nel gioco"
                dbObject={moves}
                buttons={buttons}
            />
        </>
    );
}

export default Mosse;

import React from 'react';
import { usePage } from "@inertiajs/react";
import GeneralTable from "../../Components/GeneralTable";
import { buttons,setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import userMode from "../../Components/userMode";



function Team() {
    var exemplaries = (usePage().props.teams as any[]) ?? null;
    setTableToUse("exemplaries");
    return (
        <>
            <SideBar title={"Team Corrente"} mode={userMode.user}/>
            <GeneralTable
                tableTitle="Team"
                dbObject={exemplaries}
                buttons={buttons}
            />
        </>
    );
}

export default Team
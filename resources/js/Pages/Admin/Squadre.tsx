import { usePage } from '@inertiajs/react';
import { buttons, setTableToUse } from '../../utils/buttons';
import SideBar from '../../Components/SideBar';
import GeneralTable from '../../Components/GeneralTable';
import userMode from '../../Components/userMode';
import React from 'react';
import Delete from '@mui/icons-material/Delete';

function Squadre() {
    var teams = (usePage().props.teams as any[]) ?? null;
    setTableToUse("teams");

    let buttons = [{label:"Delete", icon: Delete, url: window.location.href+"/Delete"}]

    React.useEffect(() => {
        console.log(teams);
    },[]);

    return (
        <>
        <SideBar title={"Esemplari nel team"} mode={userMode.admin}/>
        <GeneralTable tableTitle='esemplari' dbObject={teams} buttons={buttons} />
        </>
    )
  
}

export default Squadre
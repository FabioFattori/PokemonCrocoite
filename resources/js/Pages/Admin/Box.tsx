import { usePage } from '@inertiajs/react';
import React from 'react'
import { addNewInterractableButton, Button, buttons, resetButtonsConfiguration, setTableToUse } from '../../utils/buttons';
import SideBar from '../../Components/SideBar';
import userMode from '../../Components/userMode';
import GeneralTable from '../../Components/GeneralTable';
import UnarchiveIcon from '@mui/icons-material/Unarchive';
import { router } from "@inertiajs/react";

function Box() {
    var box = (usePage().props.boxes as any[]) ?? null;
    var exemplaries = (usePage().props.exemplaries as any[]) ?? null;
    var ButtonsForExemplaryTable = [] as Button[];
    setTableToUse("boxes");

    React.useEffect(() => {
        addNewInterractableButton("Show Pokemon Inside",UnarchiveIcon,({props}:{props:any}) => {
            let selection = props[0];
            console.log(selection["id"])
            //do a fetch to get all the exemplaries inside the box
            router.get("/admin/boxes",{id:selection["id"]});
        });
        return () => {
            resetButtonsConfiguration()
        }
    },[]);

    return (
        <>
        <SideBar title={"Box Pokemon"} mode={userMode.admin}/>
        <GeneralTable tableTitle='Box' dbObject={box} buttons={buttons} />
        {exemplaries != null ? <GeneralTable tableTitle='Esemplari nel box selezionato' dbObject={exemplaries} buttons={ButtonsForExemplaryTable} />:null}
        </>
    )
}

export default Box
import { router, usePage } from "@inertiajs/react";
import { addNewInterractableButton, Button, buttons, MethodButton, resetButtonsConfiguration, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import GeneralTable from "../../Components/GeneralTable";
import userMode from "../../Components/userMode";
import React from "react";
import BackpackIcon from '@mui/icons-material/Backpack';
import Delete from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import  Edit  from "@mui/icons-material/Edit";

function Npc() {
    var npcs = (usePage().props.npcs as any[]) ?? null;
    let invetory = (usePage().props.inventory as any[]) ?? null;
    let btnsInvetory = [
        { label:"Add", icon: AddIcon, url: null },{label:"Edit", icon: Edit, url: null },{label:"Delete", icon: Delete, url: !window.location.href.includes("Delete")?window.location.href.split("?npc_id")[0]+"/Delete?npc_id="+window.location.href.split("?npc_id=")[1]:window.location.href}
    ] as Button[];
    setTableToUse("npcs");

    React.useEffect(() => {
        console.log(invetory)
        addNewInterractableButton("Mostra Invetario",BackpackIcon,({ props }: { props: any })=>{
            router.get("/admin/npcs",{npc_id:props[0].id})
        })
        return () => {
            resetButtonsConfiguration();
        }
    }, []);

    return (
        <>
            <SideBar title={"Npc in tutto il gioco"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Npc"
                dbObject={npcs}
                buttons={buttons}
            />
            {invetory != null ? <GeneralTable
                tableTitle="Invetario Npc"
                dbObject={invetory}
                buttons={btnsInvetory}
            /> :null}
        </>
    );
}

export default Npc;

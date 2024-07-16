import { router, usePage } from "@inertiajs/react";
import { Button, addNewInterractableButton, buttons, resetButtonsConfiguration, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import GeneralTable from "../../Components/GeneralTable";
import userMode from "../../Components/userMode";
import React from "react";
import Brightness5Icon from '@mui/icons-material/Brightness5';
import Delete from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import  Edit  from "@mui/icons-material/Edit";
import PrecisionManufacturingIcon from '@mui/icons-material/PrecisionManufacturing';

function Mosse() {
    var pokemon = (usePage().props.pokemon as any[]) ?? null;
    let url1 = usePage().props.url1 ?? "";
    let url2 = usePage().props.url2 ?? "";
    setTableToUse("pokemons");
    let btn1 = [
        { label:"Add", icon: AddIcon, url: null },{label:"Edit", icon: Edit, url: null },{label:"Delete", icon: Delete, url: url1}
    ] as Button[];
    let btn2 = [
        { label:"Add", icon: AddIcon, url: null },{label:"Edit", icon: Edit, url: null },{label:"Delete", icon: Delete, url: url2}
    ] as Button[];
    let movesLevel = (usePage().props.moves as any[]) ?? null;
    let movesMnMt = (usePage().props.movesMn as any[]) ?? null;
    
    React.useEffect(() => {
        console.log(url1)
        console.log(url2)
        addNewInterractableButton("Mostra Mosse Imparabili per Livello",Brightness5Icon,({ props }: { props: any })=>{
            router.get("/admin/pokemons",{pokemon_id:props[0].id,mnMt:0})
        })
        addNewInterractableButton("Mostra Mosse Imparabili Tramite Mn e Mt",PrecisionManufacturingIcon,({ props }: { props: any })=>{

            router.get("/admin/pokemons",{pokemon_id:props[0].id,mnMt:1})
        })
        return () => {
            resetButtonsConfiguration();
        }
    }, []);

    return (
        <>
            <SideBar title={"Razze Pokemon"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Tutte le tipologie di Pokemon presenti nel gioco"
                dbObject={pokemon}
                buttons={buttons}
            />
            {movesLevel != null ? <GeneralTable
                tableTitle="Mosse Imparabili per Livello"
                dbObject={movesLevel}
                rootForPagination={window.location.href}
                buttons={btn1}
            /> :null}
            {movesMnMt != null ? <GeneralTable
                tableTitle="Mosse Imparabili Tramite Mn e Mt"
                rootForPagination={window.location.href}
                dbObject={movesMnMt}
                buttons={btn2}
            /> :null}
            
        </>
    );
}

export default Mosse;

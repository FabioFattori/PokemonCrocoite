import React from "react";
import { usePage } from "@inertiajs/react";
import { addNewInterractableButton, buttons, setTableToUse,resetButtonsConfiguration } from "../../utils/buttons";
import userMode from "../../Components/userMode";
import SideBar from "../../Components/SideBar";
import GeneralTable from "../../Components/GeneralTable";
import ExpandCircleDownIcon from '@mui/icons-material/ExpandCircleDown';

function Battaglie() {
    var battaglie = (usePage().props.battles as any[]) ?? null;
    setTableToUse("battles");
    var pokemonBattles = (usePage().props.pokemonBattles as any[]) ?? null;

    React.useEffect(() => {
        console.log(battaglie);
        addNewInterractableButton("show battle details",ExpandCircleDownIcon,({ props }: { props: any })=>{
            console.log(props[0])
        })
        return () => {
            resetButtonsConfiguration();
        }
    }, []);

    return (
        <>
            <SideBar title={"Battaglie tra allenatori"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Battaglie"
                dbObject={battaglie}
                buttons={buttons}
            />
        </>
    );
}

export default Battaglie;

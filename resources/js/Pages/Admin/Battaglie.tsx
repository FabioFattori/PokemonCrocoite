import React from "react";
import { router, usePage } from "@inertiajs/react";
import { addNewInterractableButton, buttons, setTableToUse,resetButtonsConfiguration, Button, MethodButton } from "../../utils/buttons";
import userMode from "../../Components/userMode";
import SideBar from "../../Components/SideBar";
import GeneralTable from "../../Components/GeneralTable";
import ExpandCircleDownIcon from '@mui/icons-material/ExpandCircleDown';
import LooksOneIcon from '@mui/icons-material/LooksOne';
import LooksTwoIcon from '@mui/icons-material/LooksTwo';
import DBRowDisplayer from "../../Components/DBRowDisplayer";
import Delete from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import  Edit  from "@mui/icons-material/Edit";

function Battaglie() {
    var battaglie = (usePage().props.battles as any[]) ?? null;
    setTableToUse("battles");
    var pokemonBattles = (usePage().props.pokemonBattles as any[]) ?? null;

    let exemplaryToDisplay = (usePage().props.exemplary as any) ?? null;

    let buttonsForSinglePokemonBattle = [{ label:"Add", icon: AddIcon, url: null },{label:"Edit", icon: Edit, url: null },{label:"Delete", icon: Delete, url: window.location.href+"/Delete"},{
        label: "Pokemon 1 Details", icon: LooksOneIcon, method({ props }: { props: any[]; }) {
            let exId = props[0].exemplary1;
            console.log(props[0])
            router.get("/admin/battles", { battle_id: props[0].battle_id, exemplary_id: exId });
        }
    }, {
        label: "Pokemon 2 Details", icon: LooksTwoIcon, method({ props }: { props: any[]; }) {
            let exId = props[0].exemplary2;
            router.get("/admin/battles", { battle_id: props[0].battle_id, exemplary_id: exId });
        }
    }] as unknown as Button[]

    React.useEffect(() => {
        addNewInterractableButton("show battle details",ExpandCircleDownIcon,({ props }: { props: any })=>{
            router.get("/admin/battles",{battle_id:props[0].id})
        })
        return () => {
            resetButtonsConfiguration();
        }
    }, [pokemonBattles]);
    return (
        <>
            <SideBar title={"Battaglie tra allenatori"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Battaglie"
                dbObject={battaglie}
                buttons={buttons}
            />
            {pokemonBattles != null ? <GeneralTable
                tableTitle="Informazioni sulla battaglia"
                dbObject={pokemonBattles}
                buttons={buttonsForSinglePokemonBattle} /> : null}
            {exemplaryToDisplay != null ? <DBRowDisplayer id="exemplaryDisplayer" dbObject={exemplaryToDisplay} Title="Informazioni sul pokemon selezionato"/> : null}
        </>
    );
}

export default Battaglie;

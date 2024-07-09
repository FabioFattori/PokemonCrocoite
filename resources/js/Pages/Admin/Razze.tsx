import { usePage } from "@inertiajs/react";
import { buttons, setTableToUse } from "../../utils/buttons";
import SideBar from "../../Components/SideBar";
import GeneralTable from "../../Components/GeneralTable";
import userMode from "../../Components/userMode";
import React from "react";
import ChartManager from "../../Components/ChartManager";

function Mosse() {
    var pokemon = (usePage().props.pokemon as any[]) ?? null;
    setTableToUse("pokemons");
    // first chart
    let x = usePage().props.pokemonForType as any[] ?? [];
    let y = usePage().props.types as any[] ?? [];
    React.useEffect(() => {
        console.log(pokemon);
    }, []);

    return (
        <>
            <SideBar title={"Razze Pokemon"} mode={userMode.admin} />
            <GeneralTable
                tableTitle="Tutte le tipologie di Pokemon presenti nel gioco"
                dbObject={pokemon}
                buttons={buttons}
            />
            <ChartManager title="Quanti pokemon per tipo esistono?" label="Disposizione pokemon per Tipo" x={y} y = {x}/> 
        </>
    );
}

export default Mosse;

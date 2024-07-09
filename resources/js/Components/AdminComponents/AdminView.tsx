import { usePage } from "@inertiajs/react";
import React from "react";
import ChartManager from "../ChartManager";


function AdminView() {
    // first chart
    let x = usePage().props.pokemonForType as any[] ?? [];
    let y = usePage().props.types as any[] ?? [];
    //second chart
    let z = usePage().props.pokemonsMostUsed as any[] ?? [];
    let w = usePage().props.pokemonNames as any[] ?? [];
    //third chart
    let a = usePage().props.nUsersInZone as any[] ?? [];
    let b = usePage().props.zones as any[] ?? [];
    //fourth chart
    let c = usePage().props.movesTimes as any[] ?? [];
    let d = usePage().props.movesNames as any[] ?? [];

    React.useEffect(() => {
        console.log(c);
        console.log(d);
    }, []);

    return (
        <div>
            <h1 style={{fontSize:120}}>SUCAMINCHIA</h1>
            <h1 style={{fontSize:50}}>Statistiche generali</h1>
            <ChartManager title="Mosse più utilizzate (Mosse più presenti nel reparto mosse degli esemplari)" label="Mosse più utilizzate" x={d} y = {c}/> 
            <ChartManager title="Numero di giocatori per zona" label="Numero di giocatori per zona" x={b} y = {a}/> 
            <ChartManager title="Pokemon più utilizzati" label="Pokemon più utilizzati" x={w} y = {z}/> 
            <ChartManager title="Quanti pokemon per tipo esistono?" label="Disposizione pokemon per Tipo" x={y} y = {x}/> 
        </div>
    );
}

export default AdminView;

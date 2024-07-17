
import { usePage } from '@inertiajs/react'
import { Divider } from '@mui/material';
import React from 'react';
import ExemplaryCard from './ExemplaryCard';
import Pokedex from './Pokedex';

function UserView() {
    /* User Variables */
    var team: any[] = (usePage().props.team as any[]) ?? [];
    var position: any[] = (usePage().props.position as any) ?? [];
    let user = usePage().props.user as any;
    let zone = usePage().props.zone as any ?? null;
    let pokemonInZone = usePage().props.pokemonInZone as any ?? null;

    React.useEffect(() => {
      console.log(pokemonInZone)
    },[]);
  return (
    <div>
        {/* <GeneralTable tableTitle="Team" dbObject={team} buttons={[]} /> */}
        
        <Divider />
        <h1 style={{marginTop:"55px"}} className='Title'>bentornato {user.email}</h1>
        <Divider style={{marginTop:"30px",marginBottom:"30px"}}/>
        <h1 className='Title'>Posizione Attuale</h1>
        <div style={{display:"flex",flexDirection:"row"}}>
          <p style={{padding:"10px"}}>x: {position.x}</p>
          <p style={{padding:"10px"}}>y: {position.y}</p>
        </div>
        {zone != null ? <>
        <h1  className='Title'>Ti trovi nella zona {zone.name}, qui puoi trovare:</h1>
        <div style={{display:"flex", justifyContent:"center",flexWrap:"wrap"}}>
          {Object.keys(pokemonInZone).map((pokemon:any) => {
            console.log()
            return <ExemplaryCard data={pokemonInZone[pokemon]} />
          })}
        </div>
        </>:null}
        <Divider style={{marginTop:"30px",marginBottom:"30px"}} />
        <h1 style={{display:"flex",justifyContent:"center"}} className='Title'>Pokedex</h1>
        <Pokedex />
    </div>
  )
}

export default UserView
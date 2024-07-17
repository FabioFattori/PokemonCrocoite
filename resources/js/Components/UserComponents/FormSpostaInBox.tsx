

import * as React from 'react';
import Dialog from '@mui/material/Dialog';
import DialogContent from '@mui/material/DialogContent';
import DialogTitle from '@mui/material/DialogTitle';
import { Button, FormControl, InputLabel, MenuItem, Select } from '@mui/material';
import { router, usePage } from '@inertiajs/react';
import { resolveDependecieName } from '../Form';

export default function FormSpostaInBox({open,closeDialog,exe}:{open:boolean,closeDialog:()=>void,exe:any}) {
  
  let box = usePage().props.Box as any[] ?? [];
  const [inputs, setInputs] = React.useState([])
  const changeInput = (index: any, value: any) => {
    let newInputs:any = [...inputs]
    newInputs[index] = value
    setInputs(newInputs)
  }
  return (
    <div>
      <Dialog
        style={{ width: '100%' }}
        open={open}
        onClose={closeDialog}
        PaperProps={{
          component: 'form',
          onSubmit: (event: React.FormEvent<HTMLFormElement>) => {
            event.preventDefault();
          },
        }}
      >
        <DialogTitle>Scegli un box in cui spostare </DialogTitle>
        <DialogContent style={{ width: '100%' }}>
        <FormControl fullWidth>
          <InputLabel id="demo-simple-select-label">{"Box di destinazione"}</InputLabel>
          <Select
            labelId="demo-simple-select-label"
            id="demo-simple-select"
            value={inputs[0] != undefined ? inputs[0] : ""}
            label="Box di destinazione"
            onChange={(e)=>{changeInput(0,e.target.value)}}
          >
            {box.map((item: any) => {
              return <MenuItem value={item.id}>{resolveDependecieName(item)}</MenuItem>
            })}
          </Select>
        </FormControl>

        <Button style={{marginTop:"10px",width:"100%"}} variant="contained" color="primary" onClick={()=>{router.post("exemplary/inBox",{box_id:inputs[0],exemplary_id:exe.id})}}>Submit</Button>
        </DialogContent>
      </Dialog>
    </div>
  );
}
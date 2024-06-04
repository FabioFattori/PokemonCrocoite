import TextField from "@mui/material/TextField"
import React from "react"
import PasswordInput from "./PasswordInput"
import Button from '@mui/material/Button';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import dayjs from "dayjs";
import { router, usePage } from "@inertiajs/react";
import { FormControl, InputLabel, MenuItem, Select } from "@mui/material";

function resolveDependecieName(row:any){
  let result = ""
  Object.keys(row).forEach((key)=>{
    if(key.toLowerCase().includes("name")||key.toLowerCase().includes("title")||key.toLowerCase().includes("id")){
      result = row[key]
    }
  })
  return result
}



function Form({headers=[] , fieldNames=[] , data=[]}:{headers: string[], fieldNames:string[] , data: any[]}) {

  const [inputs, setInputs] = React.useState(data.length != 0 ? fieldNames.filter((field)=>field!="id").map((field)=>data[field as unknown as number]):[])

  const changeInput = (index: any, value: any) => {
    let newInputs:any = [...inputs]
    newInputs[index] = value
    setInputs(newInputs)
  }

  const dependencies = usePage().props.dependencies as any[] ?? [];
  const dependenciesNames = usePage().props.dependenciesName as any[] ?? [];

  React.useEffect(() => {
    console.log(dependencies)
  }
  , [dependencies])

  const createRequest = () => {
    let request:any = {}
    request["id"] = data.length != 0 ? data["id" as unknown as number] : null
    fieldNames.filter((field)=>field!="id").map((field, index) => {
      request[field] = inputs[index]
    })
    dependenciesNames.forEach(name => {
      request[name] = inputs[headers.indexOf(name)]
    });
    return request
  }

  return (
    <div  style={{ display:"flex" , flexDirection:"column" , gap:"30px 10px" , marginTop:"10px" , minWidth:"300px" , width:"70%" }}>
        {headers.filter((header)=>header.toLowerCase() != "id").map((header, index) => {
          return dependenciesNames.length!=0&&dependenciesNames.includes(header)? 
          <FormControl fullWidth>
          <InputLabel id="demo-simple-select-label">{header}</InputLabel>
          <Select
            labelId="demo-simple-select-label"
            id="demo-simple-select"
            value={inputs[index]}
            label={header}
            onChange={(e)=>{changeInput(index,e.target.value)}}
          >
            {dependencies.length!=0?dependencies[header as unknown as number].map((item: any) => {
              return <MenuItem value={item.id}>{resolveDependecieName(item)}</MenuItem>
            }):null}
          </Select>
        </FormControl> : header.toLowerCase().includes("password") ? <PasswordInput label={header} data={data.length != 0 ? data[fieldNames.filter((value) => value != "id")[index] as unknown as number]:inputs[index]} onChange={(e)=>changeInput(index,e.target.value)} />:

           fieldNames[index].toLowerCase().includes("date") ? <DatePicker label={header} value={data.length != 0 ?dayjs((data[fieldNames.filter((value) => value != "id")[index]as unknown as number] as string)):inputs[index]} onChange={(date)=>changeInput(date,index)} /> : <TextField
          key={index}
          required
          type={Number.isInteger(data[fieldNames.filter((value) => value != "id")[index]as unknown as number]) ? "number" : "text"}
          id="outlined-required"
          label={header}
          defaultValue={data[fieldNames.filter((value) => value != "id")[index] as unknown as number]}
          onChange={(e)=>changeInput(index,e.target.value)}
          value={inputs[index]}
        />
        })}
        
        <Button variant="contained" color="primary" onClick={()=>router.post(data.length==0?window.location.pathname+"/Add":window.location.pathname+"/Edit",createRequest())}>Submit</Button>
    </div>
  )
}

export default Form
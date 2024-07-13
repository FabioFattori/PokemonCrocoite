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
  
  //console.log(row)
  Object.keys(row).forEach((key)=>{
    //console.log(key)
    if(key.toLowerCase().includes("name")||key.toLowerCase().includes("title")||key.toLowerCase().includes("email")){
      result = row[key]
    }
  })
  if(row["x"]!=undefined && row["y"]!=undefined){
    result = "x: "+row["x"] + ", y: " + row["y"]
  }
  if(result == "" && row["level"]!=undefined){
    result = row["level"]
  }
  if(result == ""){
    result = row["id"]
  }
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
    //   console.log(dependencies)
    //   console.log(dependenciesNames)
    //  console.log(headers)
    //  console.log(fieldNames)
    //   console.log(headers.filter((header)=>header.toLowerCase() != "id"))
    //   console.log(headers.filter((header)=>header.toLowerCase() != "id").map((header, index) => {
    //   return dependenciesNames.length!=0&&dependenciesNames.includes(header)}))
    // console.log(fieldNames.map((field) => field.toLowerCase().includes("date")))
  }
  , [inputs])

  const createRequest = () => {
    let request:any = {}
    request["id"] = data.length != 0 ? data["id" as unknown as number] : null
    fieldNames.filter((field)=>field!="id").map((field, index) => {
      request[field] = inputs[index]
    })
    if(Object.entries(request).length-1 < inputs.length){
      if(Object.entries(request).map(key => key == "attacking_id").length != 0){
        request["defending_id"] = inputs[0]
      }
    }
    // dependenciesNames.forEach(name => {
    //   request[name] = inputs[headers.indexOf(name)]
    // });
    return request
  }

  return (
    <div  style={{ display:"flex" , flexDirection:"column" , gap:"30px 10px" , marginTop:"10px" , minWidth:"300px" , width:"70%" }}>
        {headers.filter((header)=>header.toLowerCase() != "id").map((header, index) => {
          return dependenciesNames.length!=0&&dependenciesNames.includes(header.split(' ')[0])? 
          <FormControl fullWidth>
          <InputLabel id="demo-simple-select-label">{header}</InputLabel>
          <Select
            labelId="demo-simple-select-label"
            id="demo-simple-select"
            value={inputs[index] != undefined ? inputs[index] : ""}
            label={header}
            onChange={(e)=>{changeInput(index,e.target.value)}}
          >
            {dependencies.length!=0?dependencies[header.split(' ')[0] as unknown as number].map((item: any) => {
              return <MenuItem value={item.id}>{resolveDependecieName(item)}</MenuItem>
            }):null}
          </Select>
        </FormControl> : header.toLowerCase().includes("password") ? <PasswordInput label={header} data={data.length != 0 ? data[fieldNames.filter((value) => value != "id")[index] as unknown as number]:inputs[index]} onChange={(e)=>changeInput(index,e.target.value)} />:

           fieldNames[index].toLowerCase().includes("date") ? <DatePicker label={header} value={data.length != 0 ?dayjs((data[fieldNames.filter((value) => value != "id")[index]as unknown as number] as string)):inputs[index]} onChange={(e)=>changeInput(index,e)} /> : <TextField
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
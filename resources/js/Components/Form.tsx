import TextField from "@mui/material/TextField"
import React from "react"
import PasswordInput from "./PasswordInput"
import Button from '@mui/material/Button';
import { DatePicker } from '@mui/x-date-pickers/DatePicker';
import dayjs from "dayjs";


function Form({headers=[] , fieldNames=[] , data=[]}:{headers: string[], fieldNames:string[] , data: any[]}) {

  

  return (
    <div  style={{ display:"flex" , flexDirection:"column" , gap:"30px 10px" , marginTop:"10px" , minWidth:"300px" , width:"70%" }}>
        {headers.filter((header)=>header.toLowerCase() != "id").map((header, index) => {
          return header.toLowerCase().includes("password") ? <PasswordInput label={header} data={data[fieldNames.filter((value) => value != "id")[index] as unknown as number]} />:

          fieldNames[index+1].toLowerCase().includes("date") ? <DatePicker value={dayjs((data[fieldNames.filter((value) => value != "id")[index]as unknown as number] as string))} /> : <TextField
          key={index}
          required
          type={Number.isInteger(data[fieldNames.filter((value) => value != "id")[index]as unknown as number]) ? "number" : "text"}
          id="outlined-required"
          label={header}
          defaultValue={data[fieldNames.filter((value) => value != "id")[index] as unknown as number]}
        />
        })}
        {/* TODO */}
        <Button variant="contained" color="primary">Submit</Button>
    </div>
  )
}

export default Form

import Delete from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import  Edit  from "@mui/icons-material/Edit";

interface Button {
    label: string;
    icon: any;
    url?: string | null;

}

let buttons = [{ label:"Add", icon: AddIcon, url: null },{label:"Edit", icon: Edit, url: null },{label:"Delete", icon: Delete, url: null}] as Button[];

const setUp = (addUrl?:string , editUrl?:string , deleteUrl?:string ) =>{
    buttons = [{ label:"Add", icon: AddIcon, url: addUrl },{label:"Edit", icon: Edit, url: editUrl },{label:"Delete", icon: Delete, url: deleteUrl}];
}



export { buttons, setUp};
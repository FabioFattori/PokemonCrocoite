import { router, usePage } from "@inertiajs/react";
import Divider from "@mui/material/Divider";
import { Alert, Drawer, Icon, Toolbar, Typography } from "@mui/material";
import React from "react";
import { styled, useTheme } from "@mui/material/styles";
import List from "@mui/material/List";
import IconButton from "@mui/material/IconButton";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import ChevronRightIcon from "@mui/icons-material/ChevronRight";
import ListItem from "@mui/material/ListItem";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import MenuIcon from "@mui/icons-material/Menu";
import MuiAppBar, { AppBarProps } from "@mui/material/AppBar";
import AdminRoutes from "./AdminComponents/AdminRoutes";
import userMode from "./userMode";
import UserRoutes from "./UserComponents/UserRoutes";

function SideBar({ title,mode }: { title: string,mode:userMode }) {
    const theme = useTheme();
    const [open, setOpen] = React.useState(false);
    const [Mode, setMode] = React.useState(mode);
    
    let Error = (usePage().props.errors as any) ?? null;
    let drawerWidth = 240;
    const AppBar = styled(MuiAppBar, {
        shouldForwardProp: (prop) => prop !== "open",
    })<AppBarProps>(({ theme, open }) => ({
        transition: theme.transitions.create(["margin", "width"], {
            easing: theme.transitions.easing.sharp,
            duration: theme.transitions.duration.leavingScreen,
        }),
        ...(open && {
            width: `calc(100% - ${drawerWidth}px)`,
            marginLeft: `${drawerWidth}px`,
            transition: theme.transitions.create(["margin", "width"], {
                easing: theme.transitions.easing.easeOut,
                duration: theme.transitions.duration.enteringScreen,
            }),
        }),
    }));
    const DrawerHeader = styled("div")(({ theme }) => ({
        display: "flex",
        alignItems: "center",
        padding: theme.spacing(0, 1),
        // necessary for content to be below app bar
        ...theme.mixins.toolbar,
        justifyContent: "flex-end",
    }));

    const RemoveKey = (obj: any, deleteKey: string) => {
        console.log("apply Filter");
        return Object.keys(obj).reduce((result:any, key) => {
            if (key !== deleteKey) {
                result[key] = obj[key];
            }
            return result;
        }, {});
    };

    const handleDrawerOpen = () => {
        setOpen(true);
    };

    const handleDrawerClose = () => {
        setOpen(false);
    };
    return (
        <div>
            <AppBar position="fixed" open={open}>
            {Object.keys(Error).length != 0 ? Object.keys(Error).map((key)=>{
            return (
                <Alert className="allert" severity="error" >{Error[key]}</Alert>
            )
        }) : null}
            
                <Toolbar>
                    <IconButton
                        color="inherit"
                        aria-label="open drawer"
                        onClick={handleDrawerOpen}
                        edge="start"
                        sx={{ mr: 2, ...(open && { display: "none" }) }}
                    >
                        <MenuIcon />
                    </IconButton>
                    <Typography variant="h6" noWrap component="div">
                        {title}
                    </Typography>
                </Toolbar>
            </AppBar>
            
            
            <Drawer
                sx={{
                    width: drawerWidth,
                    flexShrink: 0,
                    "& .MuiDrawer-paper": {
                        width: drawerWidth,
                        boxSizing: "border-box",
                    },
                }}
                variant="persistent"
                anchor="left"
                open={open}
            >
                <DrawerHeader>
                    <IconButton onClick={handleDrawerClose}>
                        {theme.direction === "ltr" ? (
                            <ChevronLeftIcon />
                        ) : (
                            <ChevronRightIcon />
                        )}
                    </IconButton>
                </DrawerHeader>
                <Divider />
                <List>
                    {Mode == userMode.admin ? AdminRoutes.map((singleRoute, id) => (
                        <ListItem key={id} disablePadding>
                            <ListItemButton
                                onClick={() => router.get(singleRoute["Path"])}
                            >
                                <ListItemIcon>
                                    <Icon component={singleRoute["Icon"]} />
                                </ListItemIcon>
                                <ListItemText primary={singleRoute["Title"]} />
                            </ListItemButton>
                        </ListItem>
                    )) : UserRoutes.map((singleRoute, id) => (
                        <ListItem key={id} disablePadding>
                            <ListItemButton
                                onClick={() => router.get(singleRoute["Path"])}
                            >
                                <ListItemIcon>
                                    <Icon component={singleRoute["Icon"]} />
                                </ListItemIcon>
                                <ListItemText primary={singleRoute["Title"]} />
                            </ListItemButton>
                        </ListItem>
                    ))}
                </List>
            
            </Drawer>
            
        </div>
    );
}

export default SideBar;

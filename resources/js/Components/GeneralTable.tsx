import * as React from 'react';
import { alpha } from '@mui/material/styles';
import Box from '@mui/material/Box';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TablePagination from '@mui/material/TablePagination';
import TableRow from '@mui/material/TableRow';
import TableSortLabel from '@mui/material/TableSortLabel';
import Toolbar from '@mui/material/Toolbar';
import Typography from '@mui/material/Typography';
import Paper from '@mui/material/Paper';
import Checkbox from '@mui/material/Checkbox';
import IconButton from '@mui/material/IconButton';
import Tooltip from '@mui/material/Tooltip';
import { router } from '@inertiajs/react';
import Delete from '@mui/icons-material/Delete';
import Edit from '@mui/icons-material/Edit';
import DialogForm from './DialogForm';









interface EnhancedTableProps {
  numSelected: number;
  onRequestSort: (event: React.MouseEvent<unknown>, property: any) => void;
  onSelectAllClick: (event: React.ChangeEvent<HTMLInputElement>) => void;

  rowCount: number;
}



interface EnhancedTableToolbarProps {
  numSelected: number;
  title: string;
  buttons: { label:string, icon: any; url?: string | null }[];
  openCreateDialog?: () => void;
  openEditDialog?: () => void;
}

function EnhancedTableToolbar(props: EnhancedTableToolbarProps) {
  const { numSelected } = props;
  const { title } = props;
  const { buttons } = props;

  const { openCreateDialog } = props;
  const { openEditDialog } = props;

  return (
    <Toolbar
      sx={{
        pl: { sm: 2 },
        pr: { xs: 1, sm: 1 },
        ...(numSelected > 0 && {
          bgcolor: (theme) =>
            alpha(theme.palette.primary.main, theme.palette.action.activatedOpacity),
        }),
      }}
    >
      {numSelected > 0 ? (
        <Typography
          sx={{ flex: '1 1 100%' }}
          color="inherit"
          variant="subtitle1"
          component="div"
        >
          {numSelected} selected
        </Typography>
      ) : (
        <Typography
          sx={{ flex: '1 1 100%' }}
          variant="h6"
          id="tableTitle"
          component="div"
        >
          {title}
        </Typography>
      )}
      {numSelected == 1 && buttons.filter((btn)=>btn.label == "Edit" || btn.label == "Delete").length != 0 ? 
        
          <>
          <Tooltip title="Edit">
            <IconButton onClick={()=>buttons[1].url != null ? router.post(buttons[1].url): openEditDialog != undefined ? openEditDialog() : console.log("create")} >
              <Edit />
            </IconButton>
          </Tooltip>
          <Tooltip title="Delete">
          <IconButton onClick={()=>buttons[2].url != null ? router.post(buttons[2].url):null} >
            <Delete />
          </IconButton>
        </Tooltip>
          </>
        
      : numSelected > 0 && buttons.length >= 3 ? (
        <Tooltip title="Delete">
          <IconButton onClick={()=>buttons[1].url != null ? router.post(buttons[1].url): console.log("Delete Clicked")  } >
            <Delete />
          </IconButton>
        </Tooltip>
      ) : null}


        {buttons.filter((button)=>button.label != "Delete" && button.label != "Edit" ).map((button,key) => (
          <Tooltip title={button.label} key={key}>
            <IconButton onClick={()=>button.url != null ? router.post(button.url): openCreateDialog != undefined ? openCreateDialog() : console.log("create")} >
              <button.icon />
            </IconButton>
          </Tooltip>))}
        
      
    </Toolbar>
  );
}
export default function GeneralTable({
    tableTitle = "Table",
    fieldNames = [],
    headers = [],
    data = [],
    buttons = [],
}: {
    tableTitle: string;
    fieldNames: string[];
    headers: string[];
    data: any[];
    buttons: { label:string, icon: any; url?: string | null }[];
}) {
  
  const [selected, setSelected] = React.useState<any[]>([]);
  const [page, setPage] = React.useState(0);
  const [rowsPerPage, setRowsPerPage] = React.useState(5);

  function EnhancedTableHead(props: EnhancedTableProps) {
    const { onSelectAllClick,  numSelected, rowCount, onRequestSort } =
      props;
    const createSortHandler =
      (property: any) => (event: React.MouseEvent<unknown>) => {
        onRequestSort(event, property);
      };
  
    return (
      <TableHead>
        <TableRow>
          <TableCell padding="checkbox">
            <Checkbox
              color="primary"
              indeterminate={numSelected > 0 && numSelected < rowCount}
              checked={rowCount > 0 && numSelected === rowCount}
              onChange={onSelectAllClick}
              inputProps={{
                'aria-label': 'select all desserts',
              }}
            />
          </TableCell>
          {headers.map((headCell) => (
            <TableCell
              key={headCell}
              align={'right'}
              padding={'normal'}
            >
              <TableSortLabel
                active={false}
                onClick={createSortHandler(fieldNames[headers.findIndex((value)=>value==headCell)] as keyof any)}
              >
                {headCell}
                
              </TableSortLabel>
            </TableCell>
          ))}
        </TableRow>
      </TableHead>
    );
  }

  const handleRequestSort = (
    event: React.MouseEvent<unknown>,
    property: keyof any,
  ) => {
    //TODO: Implement Sorting
  };

  const handleSelectAllClick = (event: React.ChangeEvent<HTMLInputElement>) => {
    if (event.target.checked) {
      
      setSelected(data);
      return;
    }
    setSelected([]);
  };

  const handleClick = (event: React.MouseEvent<unknown>, id: number) => {
    const newSelected = data[id];

    if(selected.filter((value)=>value["id"] == newSelected["id"]).length == 0){
      
      setSelected(oldSelected => [...oldSelected, newSelected]);
    }else{
      setSelected(oldSelected => oldSelected.filter((value)=>value["id"] != newSelected["id"]));
    }
  };

  const handleChangePage = (event: unknown, newPage: number) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event: React.ChangeEvent<HTMLInputElement>) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };


  const isSelected = (row:any) => selected.filter((value)=>value["id"] == row["id"]).length != 0;

  // Avoid a layout jump when reaching the last page with empty rows.
  const emptyRows =
    page > 0 ? Math.max(0, (1 + page) * rowsPerPage - data.length) : 0;

  

  
const [openCreate, setOpenCreate] = React.useState(false);
const [openEdit, setOpenEdit] = React.useState(false);


  return (
    <Box sx={{ width: '100%' }}>
      <Paper sx={{ width: '100%', mb: 2 }}>
        <EnhancedTableToolbar numSelected={selected.length} title={tableTitle} buttons={buttons} openCreateDialog={()=>setOpenCreate(true)} openEditDialog={()=>setOpenEdit(true)} />
        <TableContainer sx={{ minWidth: 1000,maxHeight: 440}}>
          <Table
            stickyHeader
            
            aria-labelledby="tableTitle"
            size={'medium'}
          >
            <EnhancedTableHead
              numSelected={selected.length}
              
              onSelectAllClick={handleSelectAllClick}
              onRequestSort={handleRequestSort}
              rowCount={data.length}
            />
            <TableBody>
              {data.map((row, index) => {
                const isItemSelected = isSelected(row);
                const labelId = `enhanced-table-checkbox-${index}`;

                return (
                  <TableRow
                    hover
                    onClick={(event) => handleClick(event, index)}
                    role="checkbox"
                    aria-checked={isItemSelected}
                    tabIndex={-1}
                    key={index}
                    selected={isItemSelected}
                    sx={{ cursor: 'pointer' }}
                  >
                    <TableCell padding="checkbox">
                      <Checkbox
                        color="primary"
                        checked={isItemSelected}
                        inputProps={{
                          'aria-labelledby': labelId,
                        }}
                      />
                    </TableCell>
                    {fieldNames.map((header,key) => {
                        return (
                            <TableCell key={key} align="right">{row[header] != null ? row[header]:"NULL"}</TableCell>
                        );
                    })}
                  </TableRow>
                );
              })}
              {emptyRows > 0 && (
                <TableRow
                  style={{
                    height: (53) * emptyRows,
                  }}
                >
                  <TableCell colSpan={6} />
                </TableRow>
              )}
            </TableBody>
          </Table>
        </TableContainer>
        <TablePagination
          rowsPerPageOptions={[5, 10, 25]}
          component="div"
          count={data.length}
          rowsPerPage={rowsPerPage}
          page={page}
          onPageChange={handleChangePage}
          onRowsPerPageChange={handleChangeRowsPerPage}
        />
      </Paper>
      <DialogForm open={openCreate} openDialog={()=>setOpenCreate(true)} closeDialog={()=>setOpenCreate(false)} fieldNames={fieldNames} headers={headers} data={[]} />
      <DialogForm open={openEdit} openDialog={()=>setOpenEdit(true)} closeDialog={()=>setOpenEdit(false)} fieldNames={fieldNames} headers={headers} data={selected[0]} />
    </Box>
  );
}


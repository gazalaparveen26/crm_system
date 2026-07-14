// filter for revenue
function filterRevenueReport(){
    let from =    document.querySelector('[name="from"]').value;
    let to =document.querySelector('[name="to"]').value;
loadPage('modules/reports/revenue.php?from='+ encodeURIComponent(from)+ '&to='+ encodeURIComponent(to));
}
// filter for invoice
function filterInvoiceReport(){
    let status =document.querySelector('[name="status"]').value;
    loadPage('modules/reports/invoice.php?status='+ encodeURIComponent(status));
}
function setActiveMenu(page){

document
.querySelectorAll('#sidebar a')
.forEach(link=>{

link.classList.remove('active');

let onclick=link.getAttribute('onclick');

if(onclick && onclick.includes(page))
{

link.classList.add('active');

}

});

}
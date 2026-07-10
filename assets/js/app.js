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

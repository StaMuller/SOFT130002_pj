function deleteCollection(obj){
    const id = obj.id;
    const ele = document.getElementById(id);
    const pa = ele.parentElement;

    const pa_id = pa.id;
    const deleteEle = document.getElementById(pa_id);
    if(deleteEle !== null){
        deleteEle.parentNode.removeChild(deleteEle);
    }
}
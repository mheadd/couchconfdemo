function(doc) {
  if(doc.selection) {
	emit(doc._id, doc.selection);
  }  
}

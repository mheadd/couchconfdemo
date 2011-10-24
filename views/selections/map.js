function(doc) {
  if(doc.type)
  emit(doc._id, {song: doc.song, group: doc.group});  
}

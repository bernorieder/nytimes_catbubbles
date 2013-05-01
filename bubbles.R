library(ggplot2)

df <- read.csv("../data_guncontrol.csv",head=TRUE,stringsAsFactors=FALSE) 

p <- ggplot(df,aes(year,subject)) +
	geom_point(aes(size=value,color=value),shape=15) +
	#geom_text(aes(label=value,size=value)) +
	scale_colour_gradient(low="blue", high="red") +
	scale_x_continuous(breaks=unique(df$year)) +
	#scale_size_identity()+
	theme_bw()+
	theme(panel.grid.major=element_line(linetype=1,color="white"), panel.grid.minor=element_line(linetype=1,color="white"), axis.text.x=element_text(angle=90,hjust=1,vjust=0,size=7), axis.text.y=element_text(size=8), legend.position = "bottom")


#p + geom_text(aes(label = Frequency), size = 3, hjust = 0.5, vjust = 3, position = "stack") 


print(p)
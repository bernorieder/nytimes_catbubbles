# read csv file (adapt filename) 
df <- read.csv("data_guantanamobay.csv",head=TRUE,stringsAsFactors=FALSE) 

# filter out earlier dates
df <- subset(df, year > '1945')

# load the ggplot library
library(ggplot2)


p <- ggplot(df,aes(year,subject)) +
	geom_point(aes(size=count,color=count),shape=1) +
	#geom_text(aes(label=count,size=count)) +
	scale_colour_gradient(low="blue", high="red") +
	scale_x_continuous(breaks=unique(df$year)) +
	theme_minimal()+
	theme(panel.grid.major=element_line(linetype=3,color="#dddddd"), panel.grid.minor=element_line(linetype=1,color="white"), axis.text.x=element_text(angle=90,hjust=1,vjust=0,size=7), axis.text.y=element_text(size=7), legend.position = "bottom")

print(p)
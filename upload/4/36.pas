uses crt;
var a,b,c:word;
f,g:text;
begin
assign(f,'ab.in');
reset(f);
readln(f,a,b);
c:=a+b;
close(f);
//delay(1000000);
assign(g,'ab.out');
rewrite(g);
writeln(g,c);
close(g);
end.
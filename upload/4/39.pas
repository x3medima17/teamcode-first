var a,b,c:integer;
f,g:text;
begin
assign(f,'sum.in');
reset(f);
readln(f,c);
a:=1;
b:=c-1;
close(f);
assign(g,'sum.out');
rewrite(g);
writeln(g,a,' ',b);
close(g);
end.



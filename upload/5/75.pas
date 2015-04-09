var
i,j,k,l,m,n,p:longint;
ini,ou:text;
a:array[1..30] of integer;
b,c:array[1..8000000] of integer;
begin
 assign(ini,'blocuri.in');
 reset(ini);
 read(ini,n,p);
  for i:=1 to n do
  read(ini,a[i]);
 close(ini);

 m:=3;
 b[1]:=a[1];
 c[1]:=0;
 b[2]:=0;
 c[2]:=a[1];
 b[3]:=0;
 c[3]:=0;
 k:=0;
  for i:=2 to n do
  begin
  l:=m;
  k:=k*3;
   for j:=1 to l do
   begin
    if c[j]=p then
    begin
    m:=m+1;
    b[m]:=b[j];
    c[m]:=c[j];
     if b[j]+a[i]<p then
     begin
     m:=m+1;
     b[m]:=b[j]+a[i];
     c[m]:=c[j];
     end else k:=k+1;
    end;

    if b[j]=p then
    begin
    m:=m+1;
    b[m]:=b[j];
    c[m]:=c[j];
     if c[j]+a[i]<p then
     begin
     m:=m+1;
     b[m]:=b[j];
     c[m]:=c[j]+a[i];
     end else k:=k+1;
    end;

    if (b[j]<p) and (c[j]<p) then
    begin
    m:=m+1;
    b[m]:=b[j];
    c[m]:=c[j]+a[i];
    if c[m]>p then c[m]:=p;

    m:=m+1;
    b[m]:=b[j]+a[i];
    c[m]:=c[j];
    if b[m]>p then b[m]:=p;
    end;
   end;
  end;

 assign(ou,'blocuri.out');
 rewrite(ou);
 writeln(ou,k);
 close(ou);
end.